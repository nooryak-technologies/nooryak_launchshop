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
        $cleanHost = preg_replace('/^(launchshop|app|www)\./i', '', $host);

        // 1. If host is nooryak.in or localhost, stay on default main company database
        if ($cleanHost === 'nooryak.in' || $cleanHost === '127.0.0.1' || $cleanHost === 'localhost') {
            return $next($request);
        }

        // 2. Query Sass_admin DB to find agency matching custom_domain
        try {
            $agency = DB::table('agencies')
                ->where(function ($q) use ($cleanHost) {
                    $q->where('custom_domain', $cleanHost)
                      ->orWhere('custom_domain', "https://{$cleanHost}")
                      ->orWhere('custom_domain', "http://{$cleanHost}");
                })
                ->where('type', 'white_label')
                ->first();

            if ($agency) {
                // Find dynamic database for launchshop product
                $agencyProduct = DB::table('agency_products')
                    ->join('products', 'agency_products.product_id', '=', 'products.id')
                    ->where('agency_products.agency_id', $agency->id)
                    ->where('products.slug', 'launchshop')
                    ->select('agency_products.db_name')
                    ->first();

                $targetDb = $agencyProduct->db_name ?? null;

                if (!$targetDb) {
                    $cpanelUser = env('CPANEL_USER', 'bazaarwa');
                    $agencySlug = \Illuminate\Support\Str::slug($agency->name);
                    $cleanAgencySlug = str_replace('-', '_', substr($agencySlug, 0, 16));
                    $targetDb = "{$cpanelUser}_{$cleanAgencySlug}_launchshop";
                }

                if ($targetDb) {
                    // Check if dynamic DB exists
                    $dbExists = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$targetDb]);

                    if (!empty($dbExists)) {
                        DB::purge('mysql');
                        config(['database.connections.mysql.database' => $targetDb]);
                        DB::reconnect('mysql');
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning("TenantDatabaseMiddleware warning: " . $e->getMessage());
        }

        return $next($request);
    }
}
