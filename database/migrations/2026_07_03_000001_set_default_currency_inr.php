<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetDefaultCurrencyInr extends Migration
{
    /**
     * Run the migrations.
     * Sets INR (₹) as the default currency for ALL existing store users.
     * - Updates any existing default currency that is NOT INR → INR
     * - For users who have no currency at all, inserts INR as default
     */
    public function up()
    {
        // 1. Update every row that is currently the default but is not INR
        DB::table('user_currencies')
            ->where('is_default', 1)
            ->where('text', '!=', 'INR')
            ->update([
                'text'          => 'INR',
                'symbol'        => '₹',
                'value'         => 1,
                'text_position' => 'left',
                'symbol_position' => 'left',
            ]);

        // 2. For users that have NO currency at all, insert INR
        $usersWithNoCurrency = DB::table('users')
            ->leftJoin('user_currencies', 'users.id', '=', 'user_currencies.user_id')
            ->whereNull('user_currencies.id')
            ->pluck('users.id');

        foreach ($usersWithNoCurrency as $userId) {
            DB::table('user_currencies')->insert([
                'text'           => 'INR',
                'symbol'         => '₹',
                'value'          => 1,
                'is_default'     => 1,
                'text_position'  => 'left',
                'symbol_position'=> 'left',
                'user_id'        => $userId,
            ]);
        }

        // 3. Make sure non-default rows are still 0 (unchanged)
        // No action needed, we only touched is_default=1 rows above.
    }

    /**
     * Reverse the migrations.
     * NOTE: We cannot reliably revert currency changes, so this is intentionally empty.
     */
    public function down()
    {
        // Not reversible — currency changes are business data
    }
}
