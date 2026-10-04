<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusChangedNotification extends Notification
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
            'title' => 'تحديث حالة الموعد',
            'title_en' => 'Appointment Status Updated',
            'status' => $this->appointment->status->value,
            'status_label_ar' => $this->appointment->status->labelAr(),
            'status_label_en' => $this->appointment->status->label(),
            'message' => "تم تحديث حالة موعدك إلى {$this->appointment->status->labelAr()}",
            'message_en' => "Your appointment status was updated to {$this->appointment->status->label()}",
        ];
    }
}
