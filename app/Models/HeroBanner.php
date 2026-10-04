<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'badge_ar',
        'badge_en',
        'description_ar',
        'description_en',
        'button_text_ar',
        'button_text_en',
        'button_url',
        'secondary_button_text_ar',
        'secondary_button_text_en',
        'secondary_button_url',
        'image',
        'mobile_image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getBadgeAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->badge_ar ?: $this->badge_en) : ($this->badge_en ?: $this->badge_ar);
    }

    public function getDescriptionAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getButtonTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->button_text_ar ?: $this->button_text_en) : ($this->button_text_en ?: $this->button_text_ar);
    }

    public function getSecondaryButtonTextAttribute(): ?string
    {
        return app()->getLocale() === 'ar' ? ($this->secondary_button_text_ar ?: $this->secondary_button_text_en) : ($this->secondary_button_text_en ?: $this->secondary_button_text_ar);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&auto=format&fit=crop&q=80';
    }
}
