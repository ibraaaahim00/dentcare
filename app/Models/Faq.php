<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_ar',
        'question_en',
        'answer_ar',
        'answer_en',
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

    public function getQuestionAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->question_ar : $this->question_en;
    }

    public function getAnswerAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->answer_ar : $this->answer_en;
    }
}
