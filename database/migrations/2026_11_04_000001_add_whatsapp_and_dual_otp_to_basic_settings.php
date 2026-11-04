<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappAndDualOtpToBasicSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('basic_settings')) {
            Schema::table('basic_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('basic_settings', 'whatsapp_status')) {
                    $table->tinyInteger('whatsapp_status')->default(1);
                }
                if (!Schema::hasColumn('basic_settings', 'whatsapp_endpoint')) {
                    $table->string('whatsapp_endpoint', 255)->nullable()->default('http://localhost:8000');
                }
                if (!Schema::hasColumn('basic_settings', 'whatsapp_access_token')) {
                    $table->string('whatsapp_access_token', 255)->nullable();
                }
                if (!Schema::hasColumn('basic_settings', 'whatsapp_instance_id')) {
                    $table->string('whatsapp_instance_id', 255)->nullable();
                }
                if (!Schema::hasColumn('basic_settings', 'dual_otp_status')) {
                    $table->tinyInteger('dual_otp_status')->default(1);
                }
                if (!Schema::hasColumn('basic_settings', 'whatsapp_otp_template')) {
                    $table->text('whatsapp_otp_template')->nullable();
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
        if (Schema::hasTable('basic_settings')) {
            Schema::table('basic_settings', function (Blueprint $table) {
                $cols = ['whatsapp_status', 'whatsapp_endpoint', 'whatsapp_access_token', 'whatsapp_instance_id', 'dual_otp_status', 'whatsapp_otp_template'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('basic_settings', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
}

