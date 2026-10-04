<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CtaSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_ar',
        'badge_en',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'button_text_ar',
        'button_text_en',
        'button_url',
        'secondary_button_text_ar',
        'secondary_button_text_en',
        'secondary_button_url',
        'phone',
        'background_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
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

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getButtonTextAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->button_text_ar : $this->button_text_en;
    }

    public function getBackgroundImageUrlAttribute(): ?string
    {
        if ($this->background_image && Storage::disk('public')->exists($this->background_image)) {
            return Storage::disk('public')->url($this->background_image);
        }

        return null;
    }
}
