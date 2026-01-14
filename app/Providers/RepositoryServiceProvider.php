<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ExaminationRepositoryInterface;
use App\Interfaces\PatientRepositoryInterface;
use App\Repositories\ExaminationRepository;
use App\Repositories\PatientRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ExaminationRepositoryInterface::class, ExaminationRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
