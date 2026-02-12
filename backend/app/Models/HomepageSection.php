<?php
// app/Models/HomepageSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\HomepageSectionItem;


class HomepageSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'key',
        'type',
        'title',
        'subtitle',
        'content',
        'background_color',
        'text_align',
        'button_text',
        'button_link',
        'button_secondary_text',
        'button_secondary_link',
        'order',
        'is_active'
    ];

    protected $casts = [
        'background_color' => 'string',
        'text_align' => 'string',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(HomepageSectionItem::class)->orderBy('order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('background')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(200)
                    ->height(200)
                    ->sharpen(10);
                $this->addMediaConversion('large')
                    ->width(1920)
                    ->height(1080)
                    ->optimize();
            });

        $this->addMediaCollection('gallery');
        $this->addMediaCollection('icons');
    }

    public function getBackgroundUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('background', 'large');
    }

    public function getBackgroundThumbAttribute(): ?string
    {
        return $this->getFirstMediaUrl('background', 'thumb');
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'name' => $media->name,
            ];
        });
    }
}
