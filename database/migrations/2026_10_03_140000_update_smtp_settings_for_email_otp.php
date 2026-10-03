<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::table('basic_extendeds')->update([
                'is_smtp' => 1,
                'smtp_host' => 'mail.nooryak.in',
                'smtp_port' => '465',
                'encryption' => 'ssl',
                'smtp_username' => 'infosaasreselling@nooryak.in',
                'smtp_password' => 'Admin@nooryak',
                'from_mail' => 'infosaasreselling@nooryak.in',
                'from_name' => 'LaunchShop',
            ]);
        } catch (\Throwable $e) {
            // ignore if table does not exist
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
