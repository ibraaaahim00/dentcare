<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'title' => 'تم حجز موعد جديد',
            'title_en' => 'New Appointment Booked',
            'message' => "تم حجز موعد بتاريخ {$this->appointment->appointment_date->format('Y-m-d')} الساعة {$this->appointment->start_time}",
            'message_en' => "Appointment booked for {$this->appointment->appointment_date->format('Y-m-d')} at {$this->appointment->start_time}",
            'status' => $this->appointment->status->value,
            'doctor_name' => $this->appointment->doctor->user->name ?? 'Doctor',
            'service_name' => $this->appointment->service->name,
        ];
    }
}
