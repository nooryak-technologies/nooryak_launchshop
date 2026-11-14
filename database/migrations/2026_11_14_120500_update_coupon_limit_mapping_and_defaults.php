<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCouponLimitMappingAndDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Ensure coupon_limit column exists on packages table
        if (Schema::hasTable('packages')) {
            if (!Schema::hasColumn('packages', 'coupon_limit')) {
                Schema::table('packages', function (Blueprint $table) {
                    $table->integer('coupon_limit')->default(0)->after('order_limit');
                });
            }
        }

        // 2. Ensure coupon_limit column exists on memberships table
        if (Schema::hasTable('memberships')) {
            if (!Schema::hasColumn('memberships', 'coupon_limit')) {
                Schema::table('memberships', function (Blueprint $table) {
                    $table->integer('coupon_limit')->default(0);
                });
            }
        }

        // 3. Update limit_key for Coupon limit feature in package_features table
        if (Schema::hasTable('package_features')) {
            DB::table('package_features')
                ->where(function ($q) {
                    $q->where('keyword', 'Coupon code')
                      ->orWhere('name', 'like', '%Coupon%');
                })
                ->update([
                    'limit_key' => 'coupon_limit',
                    'type' => 'standard',
                    'updated_at' => now(),
                ]);
        }

        // 4. Set sensible defaults for packages if null or 0
        if (Schema::hasTable('packages')) {
            DB::table('packages')->where('title', 'Basic')->where(function ($q) {
                $q->whereNull('coupon_limit')->orWhere('coupon_limit', 0);
            })->update(['coupon_limit' => 10]);

            DB::table('packages')->where('title', 'Standard')->where(function ($q) {
                $q->whereNull('coupon_limit')->orWhere('coupon_limit', 0);
            })->update(['coupon_limit' => 50]);

            DB::table('packages')->where('title', 'Premium')->where(function ($q) {
                $q->whereNull('coupon_limit')->orWhere('coupon_limit', 0);
            })->update(['coupon_limit' => 150]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
