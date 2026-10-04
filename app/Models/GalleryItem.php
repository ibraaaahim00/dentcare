<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'category',
        'image',
        'before_image',
        'after_image',
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
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=600&auto=format&fit=crop&q=80';
    }

    public function getBeforeImageUrlAttribute(): ?string
    {
        if ($this->before_image && Storage::disk('public')->exists($this->before_image)) {
            return Storage::disk('public')->url($this->before_image);
        }

        return null;
    }

    public function getAfterImageUrlAttribute(): ?string
    {
        if ($this->after_image && Storage::disk('public')->exists($this->after_image)) {
            return Storage::disk('public')->url($this->after_image);
        }

        return null;
    }
}
