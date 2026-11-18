<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileLogoToUserBasicSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_basic_settings')) {
            Schema::table('user_basic_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('user_basic_settings', 'mobile_logo')) {
                    $table->string('mobile_logo', 255)->nullable()->after('dark_logo');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('user_basic_settings')) {
            Schema::table('user_basic_settings', function (Blueprint $table) {
                if (Schema::hasColumn('user_basic_settings', 'mobile_logo')) {
                    $table->dropColumn('mobile_logo');
                }
            });
        }
    }
}
