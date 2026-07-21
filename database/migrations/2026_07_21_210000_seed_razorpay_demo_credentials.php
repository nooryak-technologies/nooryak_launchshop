<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $key = 'rzp_test_T9UaATIMf1qeO8';
        $secret = 'BQ9Z865NgRQrrIMCusfzmskZ';
        $infoJson = json_encode([
            'key' => $key,
            'secret' => $secret,
            'text' => 'Pay via your Razorpay account.'
        ]);

        // 1. Update Admin Payment Gateway for Razorpay
        DB::table('payment_gateways')
            ->where('keyword', 'razorpay')
            ->update([
                'information' => $infoJson,
                'status' => 1,
                'updated_at' => now(),
            ]);

        // 2. Get all Demo Template accounts
        $demoUserIds = User::where('preview_template', 1)->pluck('id')->toArray();

        if (!empty($demoUserIds)) {
            foreach ($demoUserIds as $userId) {
                DB::table('user_payment_gateways')
                    ->updateOrInsert(
                        ['user_id' => $userId, 'keyword' => 'razorpay'],
                        [
                            'title' => 'Razorpay',
                            'name' => 'Razorpay',
                            'type' => 'automatic',
                            'information' => $infoJson,
                            'status' => 1,
                            'updated_at' => now(),
                        ]
                    );
            }
        }

        // Also update any existing user_payment_gateways for razorpay with empty keys
        DB::table('user_payment_gateways')
            ->where('keyword', 'razorpay')
            ->where(function ($q) {
                $q->whereNull('information')
                  ->orWhere('information', '')
                  ->orWhere('information', 'LIKE', '%""%');
            })
            ->update([
                'information' => $infoJson,
                'status' => 1,
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No revert needed for test credentials
    }
};
