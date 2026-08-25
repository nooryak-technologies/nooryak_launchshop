<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantDatabaseMiddleware
{
    /**
     * Handle incoming request and dynamically resolve dynamic database for White Label agencies.
     *
     * KEY FIX: On cPanel, the launchshop MySQL user (bazaarwa_launchshop) has NO access
     * to the Sass Admin DB (bazaarwa_Sass_admindb). We must connect to the Sass Admin DB
     * using its OWN credentials (SASS_ADMIN_DB_USER / SASS_ADMIN_DB_PASSWORD) stored in .env.
     *
     * IMPORTANT: This middleware must run AFTER StartSession in Kernel.php
     */
    public function handle($request, Closure $next)
    {
        // 0. Super Admin routes MUST ALWAYS use the main database (no tenant DB switch)
        if ($request->is('X9_AdMiN-Portal_V7*') || $request->is('X9_AdMiN-Portal_V7')) {
            return $next($request);
        }

        $host = $request->getHost();

        // 1. Check if explicit agency or tenant DB is passed in query param or session
        $agencySlug = $request->query('agency') ?? $request->query('tenant') ?? session('tenant_agency_slug');
        $tenantDb   = $request->query('tenant_db') ?? session('tenant_db');

        // Guard: if session has a tenant_db, verify it still actually exists in MySQL
        if ($tenantDb && !$request->query('tenant_db')) {
            $exists = false;
            try {
                $rows   = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$tenantDb]);
                $exists = !empty($rows);
            } catch (\Throwable $e) {
                // ignore
            }
            if (!$exists) {
                Log::warning("TenantMiddleware: Stale session tenant_db '{$tenantDb}' — clearing.");
                session()->forget(['tenant_db', 'tenant_agency_slug']);
                $tenantDb   = null;
                $agencySlug = null;
            }
        }

        // 2. Extract subdomain (e.g. wibro.launchshop.nooryak.in -> wibro)
        if (!$agencySlug && !$tenantDb) {
            $parts = explode('.', $host);
            if (count($parts) >= 3 && !in_array(strtolower($parts[0]), ['www', 'app', 'launchshop', 'admin', 'localhost'])) {
                $agencySlug = $parts[0];
            }
        }

        // 3. Resolve target tenant database name
        $targetDb = null;

        if ($tenantDb) {
            $targetDb = $tenantDb;
        } elseif ($agencySlug) {
            $agency   = $this->findAgencyBySlug($agencySlug);
            if ($agency) {
                $targetDb = $this->findAgencyProductDb($agency->id);
                Log::info("TenantMiddleware: slug '{$agencySlug}' -> agency_products.db_name: " . ($targetDb ?? 'null'));
            }
            if (!$targetDb) {
                $targetDb = $this->findExistingDbBySlug($agencySlug);
                Log::info("TenantMiddleware: slug fallback DB search '{$agencySlug}': " . ($targetDb ?? 'not found'));
            }
        } else {
            $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);
            $isMain    = in_array($cleanHost, ['nooryak.in', '127.0.0.1', 'localhost', 'launchshop.in']);

            if (!$isMain) {
                $agency = $this->findAgencyByDomain($cleanHost);
                if ($agency) {
                    $targetDb = $this->findAgencyProductDb($agency->id);
                    if (!$targetDb) {
                        $agencySlug = \Illuminate\Support\Str::slug($agency->name);
                        $targetDb   = $this->findExistingDbBySlug($agencySlug);
                    }
                    Log::info("TenantMiddleware: domain '{$cleanHost}' -> '{$agency->name}' -> db: " . ($targetDb ?? 'null'));
                } else {
                    Log::info("TenantMiddleware: No agency for domain '{$cleanHost}' — main DB.");
                }
            }
        }

        // 4. Switch to tenant database if resolved and different from current
        $currentDb = config('database.connections.mysql.database');
        if ($targetDb && $targetDb !== $currentDb) {
            try {
                // IMPORTANT: Do NOT use INFORMATION_SCHEMA.SCHEMATA to check existence.
                // On cPanel, that only shows DBs the current user has privileges on.
                // Instead, attempt the connection directly — if it fails, fall back.
                DB::purge('mysql');
                config(['database.connections.mysql.database' => $targetDb]);
                DB::reconnect('mysql');
                DB::connection('mysql')->getPdo(); // throws if DB inaccessible

                session(['tenant_db' => $targetDb]);
                if ($agencySlug) {
                    session(['tenant_agency_slug' => $agencySlug]);
                }
                Log::info("TenantMiddleware: Switched to tenant DB: {$targetDb}");
            } catch (\Throwable $e) {
                // Restore original DB on failure
                Log::warning("TenantMiddleware: Cannot connect to '{$targetDb}': " . $e->getMessage() . " — restoring main DB.");
                try {
                    DB::purge('mysql');
                    config(['database.connections.mysql.database' => $currentDb]);
                    DB::reconnect('mysql');
                } catch (\Throwable $restoreEx) {
                    Log::error("TenantMiddleware: Failed to restore main DB: " . $restoreEx->getMessage());
                }
            }
        }

        return $next($request);
    }

    /**
     * Get a PDO connection to the Sass Admin DB using its own credentials.
     *
     * On cPanel, the launchshop MySQL user (bazaarwa_launchshop) has NO cross-DB access.
     * We connect using the Sass Admin DB's own credentials.
     *
     * Reads from launchshop .env (supports two naming conventions):
     *   SASS_ADMIN_DB=bazaarwa_Sass_admindb       ← DB name
     *   DB_USERNAME_admin=bazaarwa_sass_admindb   ← DB user  (existing key)
     *   DB_PASSWORD_admin=<password>              ← DB pass  (existing key)
     *
     *   OR alternatively:
     *   SASS_ADMIN_DB_USER=bazaarwa_sass_admindb
     *   SASS_ADMIN_DB_PASS=<password>
     */
    protected function getSassAdminPdo(): ?\PDO
    {
        // DB name: SASS_ADMIN_DB takes priority, fallback to DB_DATABASE_admin
        $dbName = env('SASS_ADMIN_DB') ?: env('DB_DATABASE_admin');

        // DB user: check both naming conventions
        $dbUser = env('SASS_ADMIN_DB_USER') ?: env('DB_USERNAME_admin');

        // DB password: check both naming conventions
        $dbPass = env('SASS_ADMIN_DB_PASS') ?: env('DB_PASSWORD_admin', '');

        $dbHost = env('SASS_ADMIN_DB_HOST', env('DB_HOST', '127.0.0.1'));
        $dbPort = env('SASS_ADMIN_DB_PORT', env('DB_PORT', '3306'));

        if (!$dbName || !$dbUser) {
            // Credentials not configured — fall back to same-user cross-DB (works on local)
            return null;
        }

        static $pdo = null;
        if ($pdo !== null) {
            return $pdo;
        }

        try {
            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
            $pdo = new \PDO($dsn, $dbUser, $dbPass, [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_TIMEOUT            => 5,
            ]);
            return $pdo;
        } catch (\Throwable $e) {
            Log::warning("TenantMiddleware: Cannot connect to Sass Admin DB '{$dbName}': " . $e->getMessage());
            return null;
        }
    }

    /**
     * Run a SELECT query against the Sass Admin DB.
     * Uses dedicated PDO if credentials are set, otherwise falls back to cross-DB via main connection.
     */
    protected function sassQuery(string $sql, array $bindings = []): array
    {
        // Try dedicated Sass Admin connection first (required on cPanel)
        $pdo = $this->getSassAdminPdo();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute($bindings);
                return $stmt->fetchAll(\PDO::FETCH_OBJ);
            } catch (\Throwable $e) {
                Log::debug("TenantMiddleware: sassQuery PDO error: " . $e->getMessage());
                return [];
            }
        }

        // Fallback: use main DB connection with cross-DB table prefix (works locally)
        $sassDb = env('SASS_ADMIN_DB', 'sass_admin');
        // Replace table names with prefixed versions in the SQL
        $sql = preg_replace('/\bFROM\s+agencies\b/i',         "FROM {$sassDb}.agencies",         $sql);
        $sql = preg_replace('/\bFROM\s+agency_products\b/i',  "FROM {$sassDb}.agency_products",  $sql);
        $sql = preg_replace('/\bFROM\s+products\b/i',         "FROM {$sassDb}.products",          $sql);
        $sql = preg_replace('/\bJOIN\s+agencies\b/i',         "JOIN {$sassDb}.agencies",          $sql);
        $sql = preg_replace('/\bJOIN\s+agency_products\b/i',  "JOIN {$sassDb}.agency_products",   $sql);
        $sql = preg_replace('/\bJOIN\s+products\b/i',         "JOIN {$sassDb}.products",           $sql);
        $sql = preg_replace('/\bSHOW COLUMNS FROM\s+/i',      "SHOW COLUMNS FROM {$sassDb}.",      $sql);

        try {
            return DB::select($sql, $bindings);
        } catch (\Throwable $e) {
            Log::debug("TenantMiddleware: sassQuery fallback error: " . $e->getMessage());
            return [];
        }
    }

    protected function findAgencyByDomain(string $cleanHost): ?object
    {
        $rootHost = preg_replace('/^(launchshop|app|www)\./i', '', $cleanHost);

        $sql = "SELECT id, name, slug, custom_domain FROM agencies
                WHERE custom_domain = ?
                   OR custom_domain = ?
                   OR custom_domain = ?
                   OR custom_domain = ?
                   OR custom_domain = ?
                   OR custom_domain = ?
                   OR custom_domain LIKE ?
                LIMIT 1";

        $rows = $this->sassQuery($sql, [
            $cleanHost,
            $rootHost,
            "https://{$cleanHost}",
            "http://{$cleanHost}",
            "https://{$rootHost}",
            "http://{$rootHost}",
            "%{$rootHost}%",
        ]);

        return $rows[0] ?? null;
    }

    protected function findAgencyBySlug(string $slug): ?object
    {
        $rows = $this->sassQuery(
            "SELECT id, name, slug, custom_domain FROM agencies WHERE slug = ? OR name LIKE ? LIMIT 1",
            [$slug, "%{$slug}%"]
        );

        return $rows[0] ?? null;
    }

    protected function findAgencyProductDb(int $agencyId): ?string
    {
        // Check db_name column exists
        $cols = $this->sassQuery("SHOW COLUMNS FROM agency_products LIKE 'db_name'");
        if (empty($cols)) {
            Log::debug("TenantMiddleware: db_name column missing in agency_products.");
            return null;
        }

        $rows = $this->sassQuery(
            "SELECT ap.db_name
             FROM agency_products ap
             JOIN products p ON p.id = ap.product_id
             WHERE ap.agency_id = ?
               AND p.slug = 'launchshop'
               AND ap.db_name IS NOT NULL
               AND ap.db_name != ''
             LIMIT 1",
            [$agencyId]
        );

        return $rows[0]->db_name ?? null;
    }

    protected function findExistingDbBySlug(string $slug): ?string
    {
        $cpanelUser = env('CPANEL_USER', 'bazaarwa');
        $cleanSlug  = str_replace('-', '_', substr($slug, 0, 16));

        $candidates = [
            "{$cpanelUser}_ps_{$cleanSlug}_launchshop",
            "{$cpanelUser}_{$cleanSlug}_launchshop",
            "bazaarwa_ps_{$cleanSlug}_launchshop",
            "bazaarwa_{$cleanSlug}_launchshop",
        ];

        $currentDb = config('database.connections.mysql.database');

        foreach ($candidates as $cand) {
            try {
                // Try a direct connection — avoids INFORMATION_SCHEMA privilege issue on cPanel
                DB::purge('mysql');
                config(['database.connections.mysql.database' => $cand]);
                DB::reconnect('mysql');
                DB::connection('mysql')->getPdo();
                // Success — restore original connection and return the found DB
                DB::purge('mysql');
                config(['database.connections.mysql.database' => $currentDb]);
                DB::reconnect('mysql');
                return $cand;
            } catch (\Throwable $e) {
                // DB doesn't exist or no access — try next candidate
            }
        }

        // Restore original connection
        try {
            DB::purge('mysql');
            config(['database.connections.mysql.database' => $currentDb]);
            DB::reconnect('mysql');
        } catch (\Throwable $e) {
            // ignore
        }

        return null;
    }
}
