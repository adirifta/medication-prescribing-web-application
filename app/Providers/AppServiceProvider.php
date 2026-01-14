<?php

namespace App\Providers;

use App\Interfaces\PatientRepositoryInterface;
use App\Repositories\PatientRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\MedicineApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MedicineApiService::class, function ($app) {
            return new MedicineApiService();
        });

        $this->app->singleton(
            PatientRepositoryInterface::class,
            PatientRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
