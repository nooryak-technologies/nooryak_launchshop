<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderDetailsToUserBasicSettingsTable extends Migration
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
                if (!Schema::hasColumn('user_basic_settings', 'sender_name')) {
                    $table->string('sender_name', 255)->nullable()->after('from_name');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_email')) {
                    $table->string('sender_email', 255)->nullable()->after('sender_name');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_phone')) {
                    $table->string('sender_phone', 50)->nullable()->after('sender_email');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_address')) {
                    $table->text('sender_address')->nullable()->after('sender_phone');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_city')) {
                    $table->string('sender_city', 100)->nullable()->after('sender_address');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_state')) {
                    $table->string('sender_state', 100)->nullable()->after('sender_city');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_zipcode')) {
                    $table->string('sender_zipcode', 50)->nullable()->after('sender_state');
                }
                if (!Schema::hasColumn('user_basic_settings', 'sender_country')) {
                    $table->string('sender_country', 100)->nullable()->after('sender_zipcode');
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
                $columns = [
                    'sender_name',
                    'sender_email',
                    'sender_phone',
                    'sender_address',
                    'sender_city',
                    'sender_state',
                    'sender_zipcode',
                    'sender_country',
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('user_basic_settings', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
}

