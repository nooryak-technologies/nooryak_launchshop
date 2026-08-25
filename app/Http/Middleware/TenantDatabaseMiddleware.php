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

        // 2. Extract subdomain if accessing via subdomain (e.g. amazon.launchshop.nooryak.in -> amazon)
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
                $targetDb = $this->findAgencyProductDb($agency->id, $sassDb) ?? "bazaarwa_ps_{$agencySlug}_launchshop";
            } else {
                $targetDb = "bazaarwa_ps_{$agencySlug}_launchshop";
            }
        } else {
            // Fallback: Query by custom domain (e.g. cockroachjantaparty.top or launchshop.cockroachjantaparty.top)
            $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);
            if ($cleanHost !== 'nooryak.in' && $cleanHost !== '127.0.0.1' && $cleanHost !== 'localhost') {
                list($agency, $sassDb) = $this->findAgencyByDomain($cleanHost);
                if ($agency) {
                    $targetDb = $this->findAgencyProductDb($agency->id, $sassDb);
                    if (!$targetDb) {
                        $agencySlug = \Illuminate\Support\Str::slug($agency->name);
                        $cleanAgencySlug = str_replace('-', '_', substr($agencySlug, 0, 16));
                        $targetDb = "bazaarwa_ps_{$cleanAgencySlug}_launchshop";
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

        foreach (array_unique(array_filter($databasesToTry, fn($v) => $v !== false)) as $db) {
            try {
                $table = $db ? "`{$db}`.`agencies`" : 'agencies';
                $agency = DB::table(DB::raw($table))
                    ->where(function ($q) use ($cleanHost) {
                        $q->where('custom_domain', $cleanHost)
                          ->orWhere('custom_domain', "https://{$cleanHost}")
                          ->orWhere('custom_domain', "http://{$cleanHost}");
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
                $table = $db ? "`{$db}`.`agencies`" : 'agencies';
                $agency = DB::table(DB::raw($table))
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
                $table = $db ? "`{$db}`.`agency_products`" : 'agency_products';
                $prodTable = $db ? "`{$db}`.`products`" : 'products';

                $row = DB::table(DB::raw($table))
                    ->join(DB::raw($prodTable), "{$table}.product_id", '=', "{$prodTable}.id")
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
}
