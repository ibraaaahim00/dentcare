<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController as DoctorMedicalRecordController;
use App\Http\Controllers\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\MedicalRecordController as PatientMedicalRecordController;
use App\Http\Controllers\Patient\NotificationController as PatientNotificationController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\Patient\ReviewController as PatientReviewController;
use App\Http\Controllers\PublicAppointmentController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\PublicDoctorController;
use App\Http\Controllers\PublicFaqController;
use App\Http\Controllers\PublicGalleryController;
use App\Http\Controllers\PublicServiceController;
use Illuminate\Support\Facades\Route;

// Localization Switch
Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Public Pages
Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');

Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [PublicServiceController::class, 'show'])->name('services.show');

Route::get('/doctors', [PublicDoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{id}', [PublicDoctorController::class, 'show'])->name('doctors.show');
Route::get('/doctors/{doctor}/available-slots', [PublicDoctorController::class, 'availableSlots'])->name('doctors.available-slots');

Route::get('/appointments', [PublicAppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [PublicAppointmentController::class, 'store'])->name('appointments.store');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/gallery', PublicGalleryController::class)->name('gallery');
Route::get('/faq', PublicFaqController::class)->name('faq');

Route::get('/contact', [PublicContactController::class, 'index'])->name('contact');
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');

Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms', [LegalController::class, 'terms'])->name('terms');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Patient Dashboard Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', PatientDashboardController::class)->name('dashboard');

    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [PatientAppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::get('/medical-records', [PatientMedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/{medicalRecord}', [PatientMedicalRecordController::class, 'show'])->name('medical-records.show');

    Route::post('/reviews', [PatientReviewController::class, 'store'])->name('reviews.store');

    Route::get('/profile', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PatientProfileController::class, 'update'])->name('profile.update');

    Route::get('/notifications', [PatientNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [PatientNotificationController::class, 'markAllAsRead'])->name('notifications.mark-read');
});

// Doctor Dashboard Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', DoctorDashboardController::class)->name('dashboard');

    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('appointments.show');
    Route::put('/appointments/{appointment}/status', [DoctorAppointmentController::class, 'updateStatus'])->name('appointments.update-status');

    Route::get('/patients', [DoctorPatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [DoctorPatientController::class, 'show'])->name('patients.show');

    Route::get('/medical-records/create', [DoctorMedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [DoctorMedicalRecordController::class, 'store'])->name('medical-records.store');

    Route::get('/profile', [DoctorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DoctorProfileController::class, 'update'])->name('profile.update');
});
