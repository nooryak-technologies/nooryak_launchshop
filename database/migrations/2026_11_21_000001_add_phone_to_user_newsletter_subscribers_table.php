<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('user_newsletter_subscribers')) {
            Schema::table('user_newsletter_subscribers', function (Blueprint $table) {
                if (!Schema::hasColumn('user_newsletter_subscribers', 'phone')) {
                    $table->string('phone', 50)->nullable()->after('email');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('user_newsletter_subscribers')) {
            Schema::table('user_newsletter_subscribers', function (Blueprint $table) {
                if (Schema::hasColumn('user_newsletter_subscribers', 'phone')) {
                    $table->dropColumn('phone');
                }
            });
        }
    }
};

