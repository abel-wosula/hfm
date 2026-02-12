<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('homepage_sections', function (Blueprint $table) {

            // Remove JSON column
            $table->dropColumn('settings');

            // Add new columns
            $table->string('background_color')->nullable();
            $table->string('text_align')->nullable();
        });
    }

    public function down()
    {
        Schema::table('homepage_sections', function (Blueprint $table) {

            // Restore JSON column
            $table->json('settings')->nullable();

            // Remove added fields
            $table->dropColumn([
                'background_color',
                'text_align'
            ]);
        });
    }
};
