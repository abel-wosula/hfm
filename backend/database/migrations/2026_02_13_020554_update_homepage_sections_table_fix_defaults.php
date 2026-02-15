<?php
// database/migrations/xxxx_xx_xx_xxxxxx_update_homepage_sections_table_fix_defaults.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            // Make sure key is required and unique
            $table->string('key')->nullable(false)->change();

            // Set defaults for other fields
            $table->string('type')->default('banner')->change();
            $table->string('text_align')->default('left')->change();
            $table->integer('order')->default(0)->change();
            $table->boolean('is_active')->default(true)->change();
        });
    }

    public function down()
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->string('key')->nullable()->change();
            $table->string('type')->default(null)->change();
            $table->string('text_align')->default(null)->change();
            $table->integer('order')->default(null)->change();
            $table->boolean('is_active')->default(null)->change();
        });
    }
};
