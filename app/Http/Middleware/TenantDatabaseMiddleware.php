<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantDatabaseMiddleware
{
    /**
     * Handle incoming request and dynamically resolve dynamic database for White Label agencies.
     * Rule: nooryak.in stays on main company DB (bazaarwa_launchshop).
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        // 1. Check if explicit agency or tenant DB is passed in query param or session
        $agencySlug = $request->query('agency') ?? $request->query('tenant') ?? session('tenant_agency_slug');
        $tenantDb = $request->query('tenant_db') ?? session('tenant_db');

        // 2. Extract subdomain if accessing via subdomain (e.g. wibro.launchshop.nooryak.in -> wibro)
        if (!$agencySlug && !$tenantDb) {
            $parts = explode('.', $host);
            if (count($parts) >= 3 && !in_array(strtolower($parts[0]), ['www', 'app', 'launchshop', 'admin'])) {
                $agencySlug = $parts[0];
            }
        }

        // 3. Resolve target tenant database name
        $targetDb = null;

        if ($tenantDb) {
            $targetDb = $tenantDb;
        } elseif ($agencySlug) {
            list($agency, $sassDb) = $this->findAgencyBySlug($agencySlug);
            if ($agency) {
                $targetDb = $this->findAgencyProductDb($agency->id, $sassDb);
            }
            if (!$targetDb) {
                $targetDb = $this->findExistingDbBySlug($agencySlug);
            }
        } else {
            // Fallback: Query by domain (e.g. cockroachjantaparty.top or launchshop.cockroachjantaparty.top)
            $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);
            if ($cleanHost !== 'nooryak.in' && $cleanHost !== '127.0.0.1' && $cleanHost !== 'localhost') {
                list($agency, $sassDb) = $this->findAgencyByDomain($cleanHost);
                if ($agency) {
                    $targetDb = $this->findAgencyProductDb($agency->id, $sassDb);
                    if (!$targetDb) {
                        $agencySlug = \Illuminate\Support\Str::slug($agency->name);
                        $targetDb = $this->findExistingDbBySlug($agencySlug);
                    }
                }
            }
        }

        // 4. Connect to target database if valid
        if ($targetDb) {
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
                }
            } catch (\Throwable $e) {
                Log::warning("Failed connecting to tenant DB {$targetDb}: " . $e->getMessage());
            }
        }

        return $next($request);
    }

    protected function findAgencyByDomain(string $cleanHost): array
    {
        $databasesToTry = [
            env('SASS_ADMIN_DB', 'bazaarwa_sass_admindb'),
            'bazaarwa_sass_admindb',
            'bazaarwa_sass_admin',
            null,
        ];

        $rootHost = preg_replace('/^(launchshop|app|www)\./i', '', $cleanHost);

        foreach (array_unique(array_filter($databasesToTry, fn($v) => $v !== false)) as $db) {
            try {
                $table = $db ? "{$db}.agencies" : 'agencies';
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
                // keep trying next db schema
            }
        }

        return [null, null];
    }

    protected function findAgencyBySlug(string $slug): array
    {
        $databasesToTry = [
            env('SASS_ADMIN_DB', 'bazaarwa_sass_admindb'),
            'bazaarwa_sass_admindb',
            'bazaarwa_sass_admin',
            null,
        ];

        foreach (array_unique(array_filter($databasesToTry, fn($v) => $v !== false)) as $db) {
            try {
                $table = $db ? "{$db}.agencies" : 'agencies';
                $agency = DB::table($table)
                    ->where('slug', $slug)
                    ->orWhere('name', 'like', "%{$slug}%")
                    ->first();

                if ($agency) {
                    return [$agency, $db];
                }
            } catch (\Throwable $e) {
                // keep trying next db schema
            }
        }

        return [null, null];
    }

    protected function findAgencyProductDb($agencyId, ?string $sassDb = null): ?string
    {
        $databasesToTry = array_filter([$sassDb, env('SASS_ADMIN_DB', 'bazaarwa_sass_admindb'), 'bazaarwa_sass_admindb', null]);

        foreach (array_unique($databasesToTry) as $db) {
            try {
                $table = $db ? "{$db}.agency_products" : 'agency_products';
                $prodTable = $db ? "{$db}.products" : 'products';

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
                // try next
            }
        }

        return null;
    }

    protected function findExistingDbBySlug(string $slug): ?string
    {
        $cpanelUser = env('CPANEL_USER', 'bazaarwa');
        $cleanSlug = str_replace('-', '_', substr($slug, 0, 16));

        $candidates = [
            "{$cpanelUser}_ps_{$cleanSlug}_launchshop",
            "{$cpanelUser}_{$cleanSlug}_launchshop",
            "bazaarwa_ps_{$cleanSlug}_launchshop",
            "bazaarwa_{$cleanSlug}_launchshop",
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
