<?php
// app/Models/HomepageSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $table = 'homepage_sections';

    protected $fillable = [
        'key',
        'type',
        'title',
        'subtitle',
        'content',
        'button_text',
        'button_link',
        'button_secondary_text',
        'button_secondary_link',
        'order',
        'is_active',
        'background_color',
        'text_align'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
