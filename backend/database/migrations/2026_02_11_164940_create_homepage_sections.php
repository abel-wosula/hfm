<?php
// database/migrations/2024_01_01_000002_create_homepage_sections_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('type')->default('custom'); // hero, features, gallery, testimonial, cta, custom
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->json('settings')->nullable(); // For additional configuration
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_secondary_text')->nullable();
            $table->string('button_secondary_link')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homepage_section_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->json('data')->nullable(); // For flexible data storage
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_section_items');
        Schema::dropIfExists('homepage_sections');
    }
};
