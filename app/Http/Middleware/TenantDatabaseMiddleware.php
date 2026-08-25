<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TenantDatabaseMiddleware
{
    /**
     * Dynamically switch to the agency's isolated database.
     *
     * HOW IT WORKS (no Sass Admin DB lookup needed):
     * -----------------------------------------------
     * When Sass Admin creates an agency + assigns Launchshop, it creates a DB named:
     *   bazaarwa_ps_{agency_slug}_launchshop
     *
     * This middleware reads the incoming domain/subdomain, derives the agency slug,
     * constructs the DB name using the same convention, checks it exists, and switches.
     *
     * NO cross-database queries needed!
     *
     * IMPORTANT: Must run AFTER StartSession in Kernel.php
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        // 1. Use cached tenant DB from session (avoids re-resolving every request)
        $tenantDb   = $request->query('tenant_db') ?? session('tenant_db');
        $agencySlug = $request->query('agency') ?? session('tenant_agency_slug');

        // Validate cached session DB still exists (guard against stale sessions)
        if ($tenantDb && !$request->query('tenant_db')) {
            if (!$this->dbExists($tenantDb)) {
                Log::warning("TenantMiddleware: Stale session DB '{$tenantDb}' — clearing.");
                session()->forget(['tenant_db', 'tenant_agency_slug']);
                $tenantDb   = null;
                $agencySlug = null;
            }
        }

        // 2. Resolve agency slug from URL if not in session
        if (!$tenantDb && !$agencySlug) {
            $agencySlug = $this->resolveAgencySlug($host);
        }

        // 3. Resolve the target DB name from the agency slug
        $targetDb = null;

        if ($tenantDb) {
            $targetDb = $tenantDb;
        } elseif ($agencySlug) {
            $targetDb = $this->resolveDbForSlug($agencySlug);
            Log::info("TenantMiddleware: slug '{$agencySlug}' -> resolved DB: " . ($targetDb ?? 'none'));
        }

        // 4. Switch connection if a valid agency DB was found
        $currentDb = config('database.connections.mysql.database');
        if ($targetDb && $targetDb !== $currentDb) {
            if ($this->dbExists($targetDb)) {
                DB::purge('mysql');
                config(['database.connections.mysql.database' => $targetDb]);
                DB::reconnect('mysql');
                session(['tenant_db'          => $targetDb]);
                session(['tenant_agency_slug'  => $agencySlug]);
                Log::info("TenantMiddleware: ✅ Switched to agency DB: {$targetDb}");
            } else {
                Log::warning("TenantMiddleware: ❌ DB '{$targetDb}' does not exist — staying on main DB.");
            }
        }

        return $next($request);
    }

    /**
     * Extract agency slug from the incoming hostname.
     *
     * Supported URL patterns:
     *   wibro.launchshop.cockroachjantaparty.top  -> slug = wibro
     *   wibro.launchshop.in                       -> slug = wibro
     *   wibro.nooryak.in                          -> slug = wibro
     *   wibro.com (custom domain)                 -> slug = wibro (first part)
     */
    protected function resolveAgencySlug(string $host): ?string
    {
        $mainDomains = ['launchshop.in', 'nooryak.in', 'cockroachjantaparty.top'];
        $skipSubdomains = ['www', 'app', 'launchshop', 'admin', 'mail', 'cpanel', 'webmail'];

        // Remove www. prefix
        $host = preg_replace('/^www\./i', '', $host);

        // Check if this is a subdomain of one of our main domains
        foreach ($mainDomains as $mainDomain) {
            if (str_ends_with($host, '.' . $mainDomain) || $host === $mainDomain) {
                if ($host === $mainDomain) {
                    // This IS the main domain — no tenant
                    return null;
                }
                // Strip main domain to get prefix: e.g. "wibro.launchshop" or "wibro"
                $prefix = substr($host, 0, strlen($host) - strlen($mainDomain) - 1);
                $parts  = explode('.', $prefix);
                // Take the first part (e.g. "wibro" from "wibro.launchshop")
                $slug = strtolower($parts[0] ?? '');
                if ($slug && !in_array($slug, $skipSubdomains)) {
                    return $slug;
                }
                return null;
            }
        }

        // Custom domain: e.g. wibrocorp.com — use the full clean host as identifier
        // Try to find by domain in candidates
        $cleanHost = preg_replace('/^(launchshop|app)\./i', '', $host);

        // Return the first part of domain as a slug attempt
        $parts = explode('.', $cleanHost);
        $slug  = strtolower($parts[0] ?? '');

        return (strlen($slug) > 2 && !in_array($slug, $skipSubdomains)) ? $slug : null;
    }

    /**
     * Try all DB naming conventions to find the agency's database.
     * Sass Admin creates DBs as: {cpanel_user}_ps_{clean_slug}_launchshop
     */
    protected function resolveDbForSlug(string $slug): ?string
    {
        $cpanelUser = env('CPANEL_USER', 'bazaarwa');
        $cleanSlug  = str_replace('-', '_', strtolower(substr($slug, 0, 16)));

        // Convention order: most likely first
        $candidates = [
            "{$cpanelUser}_ps_{$cleanSlug}_launchshop",   // bazaarwa_ps_wibro_launchshop
            "{$cpanelUser}_{$cleanSlug}_launchshop",       // bazaarwa_wibro_launchshop
            "bazaarwa_ps_{$cleanSlug}_launchshop",
            "bazaarwa_{$cleanSlug}_launchshop",
        ];

        foreach ($candidates as $dbName) {
            if ($this->dbExists($dbName)) {
                Log::info("TenantMiddleware: Found DB '{$dbName}' for slug '{$slug}'");
                return $dbName;
            }
        }

        return null;
    }

    /**
     * Check if a MySQL database exists (using main DB connection's MySQL user).
     * INFORMATION_SCHEMA.SCHEMATA is accessible to any MySQL user for DBs they have access to.
     */
    protected function dbExists(string $dbName): bool
    {
        try {
            $rows = DB::select(
                "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?",
                [$dbName]
            );
            return !empty($rows);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
