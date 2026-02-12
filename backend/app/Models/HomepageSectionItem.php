<?php
// app/Models/HomepageSectionItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomepageSectionItem extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'homepage_section_id',
        'title',
        'description',
        'link',
        'data',
        'order'
    ];

    protected $casts = [
        'data' => 'array',
        'order' => 'integer'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(HomepageSection::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('icon')->singleFile();
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('image');
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('icon');
    }
}
