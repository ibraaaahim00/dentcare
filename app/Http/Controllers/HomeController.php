<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\User;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository,
        protected DoctorRepositoryInterface $doctorRepository,
        protected ReviewRepositoryInterface $reviewRepository,
        protected BlogPostRepositoryInterface $blogPostRepository
    ) {}

    public function __invoke(): View
    {
        $services = $this->serviceRepository->getActiveServices()->take(6);
        $doctors = $this->doctorRepository->getActiveDoctors()->take(4);
        $reviews = $this->reviewRepository->getApprovedReviews(6);
        $blogPosts = $this->blogPostRepository->getRecentPublished(3);
        $faqs = Faq::active()->take(6)->get();

        $stats = [
            'patients_count' => User::where('role', 'patient')->count() + 1250,
            'doctors_count' => Doctor::active()->count(),
            'services_count' => $this->serviceRepository->getActiveServices()->count(),
            'completed_appointments' => Appointment::where('status', AppointmentStatus::Completed)->count() + 3800,
        ];

        return view('pages.home', compact('services', 'doctors', 'reviews', 'blogPosts', 'faqs', 'stats'));
    }
}
