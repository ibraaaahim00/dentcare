<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_ar',
        'badge_en',
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en',
        'description_ar',
        'description_en',
        'vision_ar',
        'vision_en',
        'mission_ar',
        'mission_en',
        'vision_title_ar',
        'vision_title_en',
        'vision_text_ar',
        'vision_text_en',
        'mission_title_ar',
        'mission_title_en',
        'mission_text_ar',
        'mission_text_en',
        'experience_years',
        'experience_text_ar',
        'experience_text_en',
        'image',
        'secondary_image',
        'button_text_ar',
        'button_text_en',
        'button_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getBadgeAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->badge_ar ?: $this->badge_en) : ($this->badge_en ?: $this->badge_ar);
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getSubtitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->subtitle_ar ?: $this->subtitle_en) : ($this->subtitle_en ?: $this->subtitle_ar);
    }

    public function getDescriptionAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getVisionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->vision_ar ?: $this->vision_text_ar) : ($this->vision_en ?: $this->vision_text_en);
    }

    public function getMissionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->mission_ar ?: $this->mission_text_ar) : ($this->mission_en ?: $this->mission_text_en);
    }

    public function getExperienceTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->experience_text_ar ?: 'عاماً من التميز والابتكار')
            : ($this->experience_text_en ?: 'Years of Clinical Excellence');
    }

    public function getVisionTitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->vision_title_ar ?: 'رؤيتنا') : ($this->vision_title_en ?: 'Our Vision');
    }

    public function getVisionTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->vision_text_ar : $this->vision_text_en;
    }

    public function getMissionTitleAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->mission_title_ar ?: 'رسالتنا') : ($this->mission_title_en ?: 'Our Mission');
    }

    public function getMissionTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->mission_text_ar : $this->mission_text_en;
    }

    public function getButtonTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->button_text_ar ?: $this->button_text_en) : ($this->button_text_en ?: $this->button_text_ar);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=800&auto=format&fit=crop&q=80';
    }

    public function getSecondaryImageUrlAttribute(): ?string
    {
        if ($this->secondary_image && Storage::disk('public')->exists($this->secondary_image)) {
            return Storage::disk('public')->url($this->secondary_image);
        }

        return null;
    }
}
