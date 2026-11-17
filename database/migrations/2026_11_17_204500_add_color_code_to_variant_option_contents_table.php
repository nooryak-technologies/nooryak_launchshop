<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorCodeToVariantOptionContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('variant_option_contents')) {
            Schema::table('variant_option_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('variant_option_contents', 'color_code')) {
                    $table->string('color_code', 50)->nullable()->after('option_name');
                }
            });
        }

        if (Schema::hasTable('variant_options')) {
            Schema::table('variant_options', function (Blueprint $table) {
                if (!Schema::hasColumn('variant_options', 'color_code')) {
                    $table->string('color_code', 50)->nullable();
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
        if (Schema::hasTable('variant_option_contents')) {
            Schema::table('variant_option_contents', function (Blueprint $table) {
                if (Schema::hasColumn('variant_option_contents', 'color_code')) {
                    $table->dropColumn('color_code');
                }
            });
        }

        if (Schema::hasTable('variant_options')) {
            Schema::table('variant_options', function (Blueprint $table) {
                if (Schema::hasColumn('variant_options', 'color_code')) {
                    $table->dropColumn('color_code');
                }
            });
        }
    }
}
