<?php
use Illuminate\Http\Request;
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->instance('request', Request::create('/', 'GET'));
$kernel->bootstrap();

$columns = DB::getSchemaBuilder()->getColumnListing('user_order_items');
print_r($columns);
