<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

// CRUD Resources
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
Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'destroy']);
Route::resource('faqs', FaqController::class)->only(['index', 'store', 'update', 'destroy']);

Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

// Settings & Working Hours
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('settings/clinic', [SettingController::class, 'updateClinicSettings'])->name('settings.update-clinic');
Route::post('settings/working-hours', [SettingController::class, 'updateWorkingHours'])->name('settings.update-working-hours');
