<?php

namespace App\Providers;

use App\Models\ClinicSetting;
use App\Models\WorkingHour;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (file_exists(app_path('Helpers/helpers.php'))) {
            require_once app_path('Helpers/helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.admin', 'pages.*'], function ($view) {
            try {
                if (Schema::hasTable('clinic_settings')) {
                    $settings = Cache::remember('all_clinic_settings_map', 3600, function () {
                        return ClinicSetting::all()->pluck('value', 'key')->toArray();
                    });
                    $view->with('clinicSettings', $settings);
                }

                if (Schema::hasTable('working_hours')) {
                    $workingHours = WorkingHour::query()
                        ->orderBy('day_of_week')
                        ->get();
                    $view->with('footerWorkingHours', $workingHours);
                }
            } catch (\Throwable $e) {
                $view->with('clinicSettings', []);
                $view->with('footerWorkingHours', collect());
            }
        });
    }
}
