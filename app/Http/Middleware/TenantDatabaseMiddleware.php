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

                    // Auto-seed schema if tenant database is empty!
                    $this->autoSeedTenantDatabase();

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

    protected function autoSeedTenantDatabase(): void
    {
        try {
            $rows = DB::select("SHOW TABLES");
            if (count($rows) > 0) {
                return; // Database already has tables, skip
            }

            // Database is empty! Auto-create base Launchshop schema DDL
            $sqlStatements = [
                "CREATE TABLE IF NOT EXISTS `additional_sections` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `language_id` bigint(20) UNSIGNED DEFAULT NULL, `title` varchar(255) DEFAULT NULL, `content` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `admins` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `role_id` bigint(20) UNSIGNED DEFAULT NULL, `username` varchar(255) DEFAULT NULL, `email` varchar(255) DEFAULT NULL, `password` varchar(255) DEFAULT NULL, `first_name` varchar(255) DEFAULT NULL, `last_name` varchar(255) DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `status` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "INSERT IGNORE INTO `admins` (`id`, `role_id`, `username`, `email`, `password`, `first_name`, `last_name`, `status`, `created_at`, `updated_at`) VALUES (1, NULL, 'admin', 'admin@launchshop.in', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Launchshop', 'Admin', 1, NOW(), NOW());",
                "CREATE TABLE IF NOT EXISTS `basic_extendeds` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `language_id` bigint(20) UNSIGNED DEFAULT NULL, `base_currency_symbol` varchar(255) DEFAULT '₹', `base_currency_symbol_position` varchar(255) DEFAULT 'left', `base_currency_text` varchar(255) DEFAULT 'INR', `base_currency_text_position` varchar(255) DEFAULT 'right', `base_currency_rate` double DEFAULT 1, `timezone` varchar(255) DEFAULT 'Asia/Kolkata', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "INSERT IGNORE INTO `basic_extendeds` (`id`, `language_id`, `base_currency_symbol`, `base_currency_symbol_position`, `base_currency_text`, `base_currency_text_position`, `base_currency_rate`, `timezone`, `created_at`, `updated_at`) VALUES (1, 1, '₹', 'left', 'INR', 'right', 1, 'Asia/Kolkata', NOW(), NOW());",
                "CREATE TABLE IF NOT EXISTS `basic_settings` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `language_id` bigint(20) UNSIGNED DEFAULT NULL, `website_title` varchar(255) DEFAULT 'Launchshop', `logo` varchar(255) DEFAULT NULL, `favicon` varchar(255) DEFAULT NULL, `email` varchar(255) DEFAULT 'admin@launchshop.in', `phone` varchar(255) DEFAULT '7200770351', `address` text DEFAULT NULL, `footer_text` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "INSERT IGNORE INTO `basic_settings` (`id`, `language_id`, `website_title`, `email`, `phone`, `created_at`, `updated_at`) VALUES (1, 1, 'Launchshop', 'admin@launchshop.in', '7200770351', NOW(), NOW());",
                "CREATE TABLE IF NOT EXISTS `bcategories` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `language_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(255) DEFAULT NULL, `slug` varchar(255) DEFAULT NULL, `status` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `blogs` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `bcategory_id` bigint(20) UNSIGNED DEFAULT NULL, `language_id` bigint(20) UNSIGNED DEFAULT NULL, `title` varchar(255) DEFAULT NULL, `slug` varchar(255) DEFAULT NULL, `content` text DEFAULT NULL, `main_image` varchar(255) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `coupons` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(255) DEFAULT NULL, `code` varchar(255) DEFAULT NULL, `type` varchar(255) DEFAULT 'fixed', `value` double DEFAULT 0, `start_date` date DEFAULT NULL, `end_date` date DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `customers` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `username` varchar(255) DEFAULT NULL, `email` varchar(255) DEFAULT NULL, `phone` varchar(255) DEFAULT NULL, `password` varchar(255) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `email_templates` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `email_type` varchar(255) DEFAULT NULL, `email_subject` varchar(255) DEFAULT NULL, `email_body` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `languages` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `name` varchar(255) DEFAULT 'English', `code` varchar(255) DEFAULT 'en', `is_default` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "INSERT IGNORE INTO `languages` (`id`, `name`, `code`, `is_default`, `created_at`, `updated_at`) VALUES (1, 'English', 'en', 1, NOW(), NOW());",
                "CREATE TABLE IF NOT EXISTS `packages` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `title` varchar(255) DEFAULT NULL, `price` double DEFAULT 0, `term` varchar(255) DEFAULT 'monthly', `status` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `users` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `first_name` varchar(255) DEFAULT NULL, `last_name` varchar(255) DEFAULT NULL, `company_name` varchar(255) DEFAULT NULL, `username` varchar(255) DEFAULT NULL, `email` varchar(255) DEFAULT NULL, `password` varchar(255) DEFAULT NULL, `phone` varchar(255) DEFAULT NULL, `status` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `user_orders` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `order_number` varchar(255) DEFAULT NULL, `total` double DEFAULT 0, `payment_status` varchar(255) DEFAULT 'pending', `order_status` varchar(255) DEFAULT 'pending', `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
                "CREATE TABLE IF NOT EXISTS `user_shops` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `user_id` bigint(20) UNSIGNED DEFAULT NULL, `name` varchar(255) DEFAULT NULL, `domain` varchar(255) DEFAULT NULL, `status` tinyint(4) NOT NULL DEFAULT 1, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
            ];

            foreach ($sqlStatements as $sql) {
                try {
                    DB::statement($sql);
                } catch (\Throwable $e) {
                    Log::warning("Auto-seed SQL statement failed: " . $e->getMessage());
                }
            }
            Log::info("Auto-seeded Launchshop schema into empty tenant database.");
        } catch (\Throwable $e) {
            Log::warning("autoSeedTenantDatabase error: " . $e->getMessage());
        }
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
