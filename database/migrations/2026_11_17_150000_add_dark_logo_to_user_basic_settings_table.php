<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_basic_settings')) {
            Schema::table('user_basic_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('user_basic_settings', 'dark_logo')) {
                    $table->string('dark_logo', 255)->nullable()->after('logo');
                }
            });
        }

        // Ensure Razorpay status is active in payment_gateways
        try {
            if (Schema::hasTable('payment_gateways')) {
                DB::table('payment_gateways')
                    ->where('keyword', 'razorpay')
                    ->update(['status' => 1]);
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user_basic_settings')) {
            Schema::table('user_basic_settings', function (Blueprint $table) {
                if (Schema::hasColumn('user_basic_settings', 'dark_logo')) {
                    $table->dropColumn('dark_logo');
                }
            });
        }
    }
};
