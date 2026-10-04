<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CtaSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\HowItWorkController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

// CRUD Resources
Route::get('doctors/{doctor}/schedule', [DoctorController::class, 'editSchedule'])->name('doctors.schedule.edit');
Route::match(['put', 'patch', 'post'], 'doctors/{doctor}/schedule', [DoctorController::class, 'updateSchedule'])->name('doctors.schedule.update');
Route::resource('doctors', DoctorController::class);
Route::resource('patients', PatientController::class);
Route::resource('services', ServiceController::class);

Route::resource('appointments', AppointmentController::class)->except(['create', 'store']);
Route::match(['put', 'patch'], 'appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');

Route::resource('medical-records', MedicalRecordController::class);

Route::resource('reviews', ReviewController::class)->only(['index', 'destroy']);
Route::match(['put', 'patch'], 'reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.update-status');

Route::resource('blog', BlogPostController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::patch('gallery/{gallery}/toggle', [GalleryController::class, 'toggle'])->name('gallery.toggle');
Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::patch('faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');
Route::resource('faqs', FaqController::class)->only(['index', 'store', 'update', 'destroy']);

Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

// CMS Management Routes
Route::patch('hero-banners/{heroBanner}/toggle', [HeroBannerController::class, 'toggle'])->name('hero-banners.toggle');
Route::resource('hero-banners', HeroBannerController::class);

Route::get('about-section', [AboutSectionController::class, 'edit'])->name('about-section.edit');
Route::match(['put', 'patch', 'post'], 'about-section', [AboutSectionController::class, 'update'])->name('about-section.update');

Route::resource('statistics', StatisticController::class)->except(['show', 'create', 'edit']);
Route::resource('features', FeatureController::class)->except(['show', 'create', 'edit']);
Route::resource('how-it-works', HowItWorkController::class)->except(['show', 'create', 'edit']);

Route::get('cta-section', [CtaSectionController::class, 'edit'])->name('cta-section.edit');
Route::match(['put', 'patch', 'post'], 'cta-section', [CtaSectionController::class, 'update'])->name('cta-section.update');

// Settings & Working Hours
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('settings/clinic', [SettingController::class, 'updateClinicSettings'])->name('settings.update-clinic');
Route::post('settings/working-hours', [SettingController::class, 'updateWorkingHours'])->name('settings.update-working-hours');
