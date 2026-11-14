<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Package;

class AddMonthlyPremiumPackageAndRenameDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Package::ensureMonthlyPremiumExists();
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
