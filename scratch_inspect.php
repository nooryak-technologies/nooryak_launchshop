<?php
use Illuminate\Http\Request;
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->instance('request', Request::create('/', 'GET'));
$kernel->bootstrap();

function checkColumns($table) {
    if (DB::getSchemaBuilder()->hasTable($table)) {
        echo "--- TABLE: $table ---\n";
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        print_r($columns);
    } else {
        echo "Table $table does not exist.\n";
    }
}

checkColumns('user_blogs');
checkColumns('user_blog_contents');
checkColumns('user_blog_categories');
checkColumns('user_item_contents');
checkColumns('user_page_contents');
checkColumns('memberships');
