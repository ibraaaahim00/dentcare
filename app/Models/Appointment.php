<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'patient_notes',
        'doctor_notes',
        'cancellation_reason',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'status' => AppointmentStatus::class,
            'confirmed_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function medicalRecord(): HasOne
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->toTimeString();

        return $query->where(function ($q) use ($today, $nowTime) {
            $q->where('appointment_date', '>', $today)
                ->orWhere(function ($sub) use ($today, $nowTime) {
                    $sub->where('appointment_date', '=', $today)
                        ->where('start_time', '>=', $nowTime);
                });
        })->whereIn('status', [AppointmentStatus::Pending, AppointmentStatus::Confirmed]);
    }

    public function scopePast(Builder $query): Builder
    {
        $today = Carbon::today()->toDateString();
        $nowTime = Carbon::now()->toTimeString();

        return $query->where(function ($q) use ($today, $nowTime) {
            $q->where('appointment_date', '<', $today)
                ->orWhere(function ($sub) use ($today, $nowTime) {
                    $sub->where('appointment_date', '=', $today)
                        ->where('end_time', '<', $nowTime);
                });
        });
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('appointment_date', Carbon::today());
    }

    public function getStartDateTimeAttribute(): Carbon
    {
        return Carbon::parse($this->appointment_date->format('Y-m-d').' '.$this->start_time);
    }

    public function canBeCancelledByPatient(int $cancellationHours = 4): bool
    {
        if (! in_array($this->status, [AppointmentStatus::Pending, AppointmentStatus::Confirmed], true)) {
            return false;
        }

        $appointmentDateTime = $this->start_date_time;

        return Carbon::now()->addHours($cancellationHours)->lessThanOrEqualTo($appointmentDateTime);
    }
}
