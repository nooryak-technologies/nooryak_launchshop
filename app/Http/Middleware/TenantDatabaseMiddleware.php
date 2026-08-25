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
            try {
                $agency = DB::table('agencies')
                    ->where('slug', $agencySlug)
                    ->orWhere('name', 'like', "%{$agencySlug}%")
                    ->first();

                if ($agency) {
                    $agencyProduct = DB::table('agency_products')
                        ->join('products', 'agency_products.product_id', '=', 'products.id')
                        ->where('agency_products.agency_id', $agency->id)
                        ->where('products.slug', 'launchshop')
                        ->select('agency_products.db_name')
                        ->first();

                    $targetDb = $agencyProduct->db_name ?? "bazaarwa_ps_{$agencySlug}_launchshop";
                } else {
                    $targetDb = "bazaarwa_ps_{$agencySlug}_launchshop";
                }
            } catch (\Throwable $e) {
                Log::warning("Agency lookup failed by slug {$agencySlug}: " . $e->getMessage());
            }
        } else {
            // Fallback: Query by custom domain
            $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);
            if ($cleanHost !== 'nooryak.in' && $cleanHost !== '127.0.0.1' && $cleanHost !== 'localhost') {
                try {
                    $agency = DB::table('agencies')
                        ->where(function ($q) use ($cleanHost) {
                            $q->where('custom_domain', $cleanHost)
                              ->orWhere('custom_domain', "https://{$cleanHost}")
                              ->orWhere('custom_domain', "http://{$cleanHost}");
                        })
                        ->first();

                    if ($agency) {
                        $agencyProduct = DB::table('agency_products')
                            ->join('products', 'agency_products.product_id', '=', 'products.id')
                            ->where('agency_products.agency_id', $agency->id)
                            ->where('products.slug', 'launchshop')
                            ->select('agency_products.db_name')
                            ->first();

                        $targetDb = $agencyProduct->db_name ?? null;
                    }
                } catch (\Throwable $e) {
                    Log::warning("TenantDatabaseMiddleware domain lookup warning: " . $e->getMessage());
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
}
