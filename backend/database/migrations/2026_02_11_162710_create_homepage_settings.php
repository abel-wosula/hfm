<?php
// database/migrations/2024_01_01_000001_create_homepage_settings.php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('homepage.hero_title', 'Welcome to Holy Family Media');
        $this->migrator->add('homepage.hero_subtitle', 'The fountain of holy music');
        $this->migrator->add('homepage.hero_background', null);
        $this->migrator->add('homepage.booking_title', 'Book your session today');
        $this->migrator->add('homepage.booking_location', 'Holy Family Media - Thika, Kenya');
        $this->migrator->add('homepage.booking_phone', '+254 708 026 652');
        $this->migrator->add('homepage.booking_quote', 'Samuel Magima Family and Friends Choir - Creating divine melodies for spiritual upliftment since 2015');
        $this->migrator->add('homepage.button_book_text', 'Book your session today');
        $this->migrator->add('homepage.button_book_link', '/contact');
        $this->migrator->add('homepage.button_services_text', 'View Services');
        $this->migrator->add('homepage.button_services_link', '/services');
        $this->migrator->add('homepage.is_active', true);
        $this->migrator->add('homepage.seo_title', 'Holy Family Media - Sacred Music Studio');
        $this->migrator->add('homepage.seo_description', 'Professional recording studio specializing in sacred and holy music. Book your session today in Thika, Kenya.');
        $this->migrator->add('homepage.seo_keywords', 'holy music, sacred music, recording studio, Thika, Kenya, choir recording');
    }

    public function down(): void
    {
        $this->migrator->delete('homepage.hero_title');
        $this->migrator->delete('homepage.hero_subtitle');
        $this->migrator->delete('homepage.hero_background');
        $this->migrator->delete('homepage.booking_title');
        $this->migrator->delete('homepage.booking_location');
        $this->migrator->delete('homepage.booking_phone');
        $this->migrator->delete('homepage.booking_quote');
        $this->migrator->delete('homepage.button_book_text');
        $this->migrator->delete('homepage.button_book_link');
        $this->migrator->delete('homepage.button_services_text');
        $this->migrator->delete('homepage.button_services_link');
        $this->migrator->delete('homepage.is_active');
        $this->migrator->delete('homepage.seo_title');
        $this->migrator->delete('homepage.seo_description');
        $this->migrator->delete('homepage.seo_keywords');
    }
};
