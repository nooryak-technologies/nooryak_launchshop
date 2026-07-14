<?php
use Illuminate\Http\Request;
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->instance('request', Request::create('/', 'GET'));
$kernel->bootstrap();

try {
    // Find or create any user locally
    $user = App\Models\User::first();
    if (!$user) {
        $user = App\Models\User::create([
            'first_name' => 'Demo',
            'last_name' => 'Admin',
            'email' => 'admin@demo.com',
            'username' => 'demoadmin',
            'password' => bcrypt('password'),
            'status' => 1
        ]);
    }

    echo "Running seeder for User ID: {$user->id}\n";

    \App\Models\User\UserOrder::where('user_id', $user->id)->delete();

    $customer = \App\Models\Customer::where('user_id', $user->id)->first();
    if (!$customer) {
        $customer = \App\Models\Customer::create([
            'user_id' => $user->id,
            'first_name' => 'Mohamed',
            'last_name' => 'Imran',
            'email' => 'bahadabdul539@gmail.com',
            'phone' => '9876543210',
            'status' => 1
        ]);
    }

    $user_currency = \App\Models\User\UserCurrency::where('user_id', $user->id)->where('is_default', 1)->first();
    if (!$user_currency) {
        $user_currency = \App\Models\User\UserCurrency::where('user_id', $user->id)->first();
    }
    $currency_code = $user_currency ? $user_currency->code : 'INR';
    $currency_sign = $user_currency ? $user_currency->symbol : '₹';

    $firstNames = ['John', 'Emily', 'Michael', 'Sarah', 'David', 'Jessica', 'James', 'Ashley', 'Robert', 'Amanda'];
    $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson'];
    $gateways = ['Stripe', 'PayPal', 'Razorpay', 'Offline'];
    $statuses = ['completed', 'pending', 'processing', 'rejected'];

    for ($i = 0; $i < 5; $i++) {
        $daysAgo = rand(0, 29);
        $orderDate = \Carbon\Carbon::now()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
        
        $cart_total = rand(200, 3000);
        $tax = round($cart_total * 0.1, 2);
        $shipping_charge = rand(0, 1) ? 0 : rand(30, 120);
        $total = $cart_total + $tax + $shipping_charge;

        $status = $statuses[array_rand($statuses)];
        $payment_status = ($status == 'rejected') ? 'Pending' : 'Completed';

        \App\Models\User\UserOrder::create([
            'customer_id' => $customer->id,
            'user_id' => $user->id,
            'billing_country' => 'India',
            'billing_fname' => $firstNames[array_rand($firstNames)],
            'billing_lname' => $lastNames[array_rand($lastNames)],
            'billing_address' => 'Street ' . rand(1, 200),
            'billing_city' => 'Chennai',
            'billing_email' => 'customer' . rand(1, 100) . '@demo.com',
            'billing_number' => '98765' . rand(10000, 99999),
            'shipping_country' => 'India',
            'shipping_fname' => $firstNames[array_rand($firstNames)],
            'shipping_lname' => $lastNames[array_rand($lastNames)],
            'shipping_address' => 'Street ' . rand(1, 200),
            'shipping_city' => 'Chennai',
            'shipping_email' => 'customer' . rand(1, 100) . '@demo.com',
            'shipping_number' => '98765' . rand(10000, 99999),
            'cart_total' => $cart_total,
            'discount' => 0,
            'tax' => $tax,
            'tax_percentage' => 10.00,
            'total' => $total,
            'method' => $gateways[array_rand($gateways)],
            'gateway_type' => 'online',
            'currency_code' => $currency_code,
            'currency_sign' => $currency_sign,
            'currency_id' => $user_currency ? $user_currency->id : 1,
            'order_number' => strtoupper(\Illuminate\Support\Str::random(4)) . time() . rand(10, 99),
            'shipping_method' => 'Standard Delivery',
            'shipping_charge' => $shipping_charge,
            'payment_status' => $payment_status,
            'order_status' => $status,
            'created_at' => $orderDate,
            'updated_at' => $orderDate
        ]);
    }

    echo "SUCCESS!\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
