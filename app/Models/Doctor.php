<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'specialization_ar',
        'specialization_en',
        'bio',
        'bio_ar',
        'bio_en',
        'qualifications',
        'qualifications_ar',
        'qualifications_en',
        'experience_years',
        'consultation_fee',
        'image',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'consultation_fee' => 'decimal:2',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'doctor_services')->withTimestamps();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getNameAttribute(): ?string
    {
        return $this->user?->name;
    }

    public function getSpecializationAttribute(?string $value): string
    {
        if (app()->getLocale() === 'ar' && ! empty($this->attributes['specialization_ar'])) {
            return $this->attributes['specialization_ar'];
        }

        if (app()->getLocale() === 'en' && ! empty($this->attributes['specialization_en'])) {
            return $this->attributes['specialization_en'];
        }

        return $value ?? '';
    }

    public function getBioAttribute(?string $value): ?string
    {
        if (app()->getLocale() === 'ar' && ! empty($this->attributes['bio_ar'])) {
            return $this->attributes['bio_ar'];
        }

        if (app()->getLocale() === 'en' && ! empty($this->attributes['bio_en'])) {
            return $this->attributes['bio_en'];
        }

        return $value;
    }

    public function getQualificationsAttribute(?string $value): ?string
    {
        if (app()->getLocale() === 'ar' && ! empty($this->attributes['qualifications_ar'])) {
            return $this->attributes['qualifications_ar'];
        }

        if (app()->getLocale() === 'en' && ! empty($this->attributes['qualifications_en'])) {
            return $this->attributes['qualifications_en'];
        }

        return $value;
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->user?->name ?? 'Dr').'&color=0284c7&background=e0f2fe';
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->reviews()->where('status', 'approved')->avg('rating'), 1) ?: 5.0;
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->where('status', 'approved')->count();
    }
}
