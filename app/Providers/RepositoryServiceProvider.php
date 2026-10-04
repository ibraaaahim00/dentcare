<?php

namespace App\Providers;

use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\Eloquent\BlogPostRepository;
use App\Repositories\Eloquent\ContactMessageRepository;
use App\Repositories\Eloquent\DoctorRepository;
use App\Repositories\Eloquent\MedicalRecordRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\ServiceRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        DoctorRepositoryInterface::class => DoctorRepository::class,
        ServiceRepositoryInterface::class => ServiceRepository::class,
        AppointmentRepositoryInterface::class => AppointmentRepository::class,
        MedicalRecordRepositoryInterface::class => MedicalRecordRepository::class,
        ReviewRepositoryInterface::class => ReviewRepository::class,
        BlogPostRepositoryInterface::class => BlogPostRepository::class,
        ContactMessageRepositoryInterface::class => ContactMessageRepository::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
