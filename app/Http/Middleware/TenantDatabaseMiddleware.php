<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantDatabaseMiddleware
{
    /**
     * Handle incoming request and dynamically resolve dynamic database for White Label agencies.
     * Rule: nooryak.in stays on main company DB (bazaarwa_launchshop / nooryak_launchshopp).
     *
     * IMPORTANT: This middleware must run AFTER StartSession in Kernel.php
     * so that session() is available.
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        // 1. Check if explicit agency or tenant DB is passed in query param or session
        $agencySlug = $request->query('agency') ?? $request->query('tenant') ?? session('tenant_agency_slug');
        $tenantDb   = $request->query('tenant_db') ?? session('tenant_db');

        // Guard: if session has a tenant_db, verify it still actually exists in MySQL
        // (prevents using a stale session pointing to a deleted/renamed DB)
        if ($tenantDb && !$request->query('tenant_db')) {
            $exists = false;
            try {
                $rows   = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$tenantDb]);
                $exists = !empty($rows);
            } catch (\Throwable $e) {
                // ignore
            }
            if (!$exists) {
                Log::warning("TenantMiddleware: Session tenant_db '{$tenantDb}' not found in MySQL — clearing stale session.");
                session()->forget(['tenant_db', 'tenant_agency_slug']);
                $tenantDb   = null;
                $agencySlug = null;
            }
        }

        // 2. Extract subdomain if accessing via subdomain (e.g. wibro.launchshop.nooryak.in -> wibro)
        if (!$agencySlug && !$tenantDb) {
            $parts = explode('.', $host);
            if (count($parts) >= 3 && !in_array(strtolower($parts[0]), ['www', 'app', 'launchshop', 'admin', 'localhost'])) {
                $agencySlug = $parts[0];
                Log::info("TenantMiddleware: Detected agency slug from subdomain: {$agencySlug}");
            }
        }

        // 3. Resolve target tenant database name
        $targetDb = null;

        if ($tenantDb) {
            // Already validated above
            $targetDb = $tenantDb;
            Log::info("TenantMiddleware: Using session tenant_db: {$targetDb}");
        } elseif ($agencySlug) {
            [$agency, $sassDb] = $this->findAgencyBySlug($agencySlug);
            if ($agency) {
                $targetDb = $this->findAgencyProductDb($agency->id, $sassDb);
                Log::info("TenantMiddleware: Agency '{$agencySlug}' (id={$agency->id}) -> db_name from agency_products: " . ($targetDb ?? 'null'));
            }
            if (!$targetDb) {
                $targetDb = $this->findExistingDbBySlug($agencySlug);
                Log::info("TenantMiddleware: Fallback slug-based DB search for '{$agencySlug}': " . ($targetDb ?? 'not found'));
            }
        } else {
            // Fallback: Query by domain (e.g. cockroachjantaparty.top or launchshop.cockroachjantaparty.top)
            $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);
            $isLocal   = in_array($cleanHost, ['nooryak.in', '127.0.0.1', 'localhost']);

            if (!$isLocal) {
                [$agency, $sassDb] = $this->findAgencyByDomain($cleanHost);
                if ($agency) {
                    $targetDb = $this->findAgencyProductDb($agency->id, $sassDb);
                    if (!$targetDb) {
                        $agencySlug = \Illuminate\Support\Str::slug($agency->name);
                        $targetDb   = $this->findExistingDbBySlug($agencySlug);
                    }
                    Log::info("TenantMiddleware: Domain '{$cleanHost}' -> agency '{$agency->name}' -> db: " . ($targetDb ?? 'null'));
                } else {
                    Log::info("TenantMiddleware: No agency found for domain '{$cleanHost}' — using main DB.");
                }
            } else {
                Log::info("TenantMiddleware: Local/main host '{$cleanHost}' — using main DB (no tenant switch).");
            }
        }

        // 4. Connect to target database if resolved and different from current
        $currentDb = config('database.connections.mysql.database');
        if ($targetDb && $targetDb !== $currentDb) {
            try {
                $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$targetDb]);

                if (!empty($dbExists)) {
                    DB::purge('mysql');
                    config(['database.connections.mysql.database' => $targetDb]);
                    DB::reconnect('mysql');
                    session(['tenant_db' => $targetDb]);
                    if ($agencySlug) {
                        session(['tenant_agency_slug' => $agencySlug]);
                    }
                    Log::info("TenantMiddleware: Switched to tenant DB: {$targetDb}");
                } else {
                    Log::warning("TenantMiddleware: Target DB '{$targetDb}' does not exist in MySQL — staying on main DB.");
                }
            } catch (\Throwable $e) {
                Log::warning("TenantMiddleware: Failed connecting to tenant DB {$targetDb}: " . $e->getMessage());
            }
        }

        return $next($request);
    }

    protected function findAgencyByDomain(string $cleanHost): array
    {
        $databasesToTry = array_unique(array_filter([
            env('SASS_ADMIN_DB'),
            'sass_admin',
            'bazaarwa_sass_admindb',
            'bazaarwa_sass_admin',
            null,
        ]));

        $rootHost = preg_replace('/^(launchshop|app|www)\./i', '', $cleanHost);

        foreach ($databasesToTry as $db) {
            try {
                $table  = $db ? "{$db}.agencies" : 'agencies';
                $agency = DB::table($table)
                    ->where(function ($q) use ($cleanHost, $rootHost) {
                        $q->where('custom_domain', $cleanHost)
                          ->orWhere('custom_domain', $rootHost)
                          ->orWhere('custom_domain', "https://{$cleanHost}")
                          ->orWhere('custom_domain', "http://{$cleanHost}")
                          ->orWhere('custom_domain', "https://{$rootHost}")
                          ->orWhere('custom_domain', "http://{$rootHost}")
                          ->orWhere('custom_domain', 'like', "%{$rootHost}%");
                    })
                    ->first();

                if ($agency) {
                    return [$agency, $db];
                }
            } catch (\Throwable $e) {
                Log::debug("TenantMiddleware: findAgencyByDomain tried db={$db}, error: " . $e->getMessage());
            }
        }

        return [null, null];
    }

    protected function findAgencyBySlug(string $slug): array
    {
        $databasesToTry = array_unique(array_filter([
            env('SASS_ADMIN_DB'),
            'sass_admin',
            'bazaarwa_sass_admindb',
            'bazaarwa_sass_admin',
            null,
        ]));

        foreach ($databasesToTry as $db) {
            try {
                $table  = $db ? "{$db}.agencies" : 'agencies';
                $agency = DB::table($table)
                    ->where('slug', $slug)
                    ->orWhere('name', 'like', "%{$slug}%")
                    ->first();

                if ($agency) {
                    return [$agency, $db];
                }
            } catch (\Throwable $e) {
                Log::debug("TenantMiddleware: findAgencyBySlug tried db={$db}, error: " . $e->getMessage());
            }
        }

        return [null, null];
    }

    protected function findAgencyProductDb($agencyId, ?string $sassDb = null): ?string
    {
        $databasesToTry = array_unique(array_filter([
            $sassDb,
            env('SASS_ADMIN_DB'),
            'sass_admin',
            'bazaarwa_sass_admindb',
            null,
        ]));

        foreach ($databasesToTry as $db) {
            try {
                $table     = $db ? "{$db}.agency_products" : 'agency_products';
                $prodTable = $db ? "{$db}.products" : 'products';

                // Guard: db_name column may not exist yet if migration hasn't run
                $hasDbCol = false;
                try {
                    $cols     = DB::select("SHOW COLUMNS FROM {$table} LIKE 'db_name'");
                    $hasDbCol = !empty($cols);
                } catch (\Throwable $e) {
                    // column check failed
                }

                if (!$hasDbCol) {
                    Log::debug("TenantMiddleware: agency_products.db_name column missing in db={$db} — skipping.");
                    continue;
                }

                $row = DB::table($table)
                    ->join($prodTable, "{$table}.product_id", '=', "{$prodTable}.id")
                    ->where("{$table}.agency_id", $agencyId)
                    ->where("{$prodTable}.slug", 'launchshop')
                    ->select("{$table}.db_name")
                    ->first();

                if ($row && !empty($row->db_name)) {
                    return $row->db_name;
                }
            } catch (\Throwable $e) {
                Log::debug("TenantMiddleware: findAgencyProductDb tried db={$db}, error: " . $e->getMessage());
            }
        }

        return null;
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
            "root_ps_{$cleanSlug}_launchshop",
        ];

        foreach ($candidates as $cand) {
            try {
                $rows = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$cand]);
                if (!empty($rows)) {
                    return $cand;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return null;
    }
}
