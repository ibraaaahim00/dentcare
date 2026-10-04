<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Enums\ContactMessageStatus;
use App\Enums\ReviewStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total_patients' => User::where('role', UserRole::Patient)->count(),
            'total_doctors' => Doctor::count(),
            'total_services' => Service::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'pending_appointments' => Appointment::where('status', AppointmentStatus::Pending)->count(),
            'completed_appointments' => Appointment::where('status', AppointmentStatus::Completed)->count(),
            'cancelled_appointments' => Appointment::where('status', AppointmentStatus::Cancelled)->count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('status', ReviewStatus::Pending)->count(),
            'unread_messages' => ContactMessage::where('status', ContactMessageStatus::Unread)->count(),
        ];

        $todayAppointmentsList = Appointment::whereDate('appointment_date', Carbon::today())
            ->with(['patient', 'doctor.user', 'service'])
            ->orderBy('start_time')
            ->take(6)
            ->get();

        $recentAppointments = Appointment::with(['patient', 'doctor.user', 'service'])
            ->latest()
            ->take(8)
            ->get();

        $recentMessages = ContactMessage::latest()->take(5)->get();

        // 7-day appointment chart breakdown
        $chartDates = [];
        $chartCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('M d');
            $chartCounts[] = Appointment::whereDate('appointment_date', $date)->count();
        }

        return view('admin.dashboard', compact(
            'stats',
            'todayAppointmentsList',
            'recentAppointments',
            'recentMessages',
            'chartDates',
            'chartCounts'
        ));
    }
}
