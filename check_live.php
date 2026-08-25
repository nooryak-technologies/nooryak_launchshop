<?php
/**
 * Upload this file to: /home/bazaarwa/launchshop.in/check_live.php
 * Run via: php check_live.php
 * DELETE after use!
 */
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sassAdminDb = env('SASS_ADMIN_DB', 'bazaarwa_Sass_admindb');

echo "=== ENV CHECK ===\n";
echo "SASS_ADMIN_DB  = " . ($sassAdminDb ?: 'NOT SET') . "\n";
echo "CPANEL_USER    = " . (env('CPANEL_USER') ?: 'NOT SET') . "\n";
echo "DB_DATABASE    = " . env('DB_DATABASE') . "\n\n";

echo "=== SASS ADMIN DB: {$sassAdminDb} ===\n";

// Check agencies table
try {
    $agencies = DB::select("SELECT id, name, slug, type, custom_domain FROM {$sassAdminDb}.agencies");
    if (empty($agencies)) {
        echo "No agencies found in {$sassAdminDb}.agencies\n";
    } else {
        foreach ($agencies as $a) {
            echo "  Agency [{$a->id}] {$a->name} | Type: {$a->type} | Domain: {$a->custom_domain}\n";
        }
    }
} catch (\Throwable $e) {
    echo "ERROR reading agencies: " . $e->getMessage() . "\n";
}

echo "\n=== PRODUCTS ===\n";
try {
    $products = DB::select("SELECT id, name, slug, is_active FROM {$sassAdminDb}.products");
    if (empty($products)) {
        echo "NO PRODUCTS FOUND — This is why agencies have no DB!\n";
        echo "Fix: Go to Sass Admin -> Products -> Add 'Launchshop' product first.\n";
    } else {
        foreach ($products as $p) {
            echo "  Product [{$p->id}] {$p->name} (slug={$p->slug}, active={$p->is_active})\n";
        }
    }
} catch (\Throwable $e) {
    echo "ERROR reading products: " . $e->getMessage() . "\n";
}

echo "\n=== AGENCY_PRODUCTS (pivot — db_name column) ===\n";
try {
    // Check if db_name column exists
    $cols = DB::select("SHOW COLUMNS FROM {$sassAdminDb}.agency_products LIKE 'db_name'");
    if (empty($cols)) {
        echo "WARNING: db_name column MISSING in {$sassAdminDb}.agency_products!\n";
        echo "Fix: Run migrations on Sass Admin: php artisan migrate --force\n";
    } else {
        $rows = DB::select("
            SELECT a.name, a.custom_domain, p.slug as product_slug,
                   ap.db_name, ap.db_status
            FROM {$sassAdminDb}.agency_products ap
            JOIN {$sassAdminDb}.agencies a  ON a.id  = ap.agency_id
            JOIN {$sassAdminDb}.products p  ON p.id  = ap.product_id
        ");
        if (empty($rows)) {
            echo "NO ROWS in agency_products — agency was created WITHOUT a product selected!\n";
            echo "Fix: Go to Sass Admin -> Agencies -> (edit agency) -> assign Launchshop product -> save.\n";
        } else {
            foreach ($rows as $r) {
                $dbStatus = $r->db_name ? "OK" : "NULL -- NOT PROVISIONED";
                echo "  Agency: {$r->name} | Domain: {$r->custom_domain}\n";
                echo "  Product: {$r->product_slug} | db_name: " . ($r->db_name ?? 'NULL') . " | db_status: {$r->db_status}\n";
                echo "  Status: {$dbStatus}\n\n";
            }
        }
    }
} catch (\Throwable $e) {
    echo "ERROR reading agency_products: " . $e->getMessage() . "\n";
}

echo "\n=== LAUNCHSHOP-RELATED DATABASES IN MYSQL ===\n";
try {
    $dbs = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA
                       WHERE SCHEMA_NAME LIKE '%launchshop%'
                          OR SCHEMA_NAME LIKE '%bazaarwa_ps_%'
                       ORDER BY SCHEMA_NAME");
    if (empty($dbs)) {
        echo "No agency DBs found yet.\n";
    } else {
        foreach ($dbs as $db) {
            echo "  DB: {$db->SCHEMA_NAME}\n";
        }
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== MIDDLEWARE SESSION TEST ===\n";
echo "Check storage/logs/laravel.log for lines starting with 'TenantMiddleware:'\n";
echo "Those logs will show exactly what DB the middleware is resolving per request.\n";
echo "\nDone. DELETE this file from server after use!\n";
