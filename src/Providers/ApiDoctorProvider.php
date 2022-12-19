<?php

namespace NiamulHasan\ApiDoctorSwagger\Providers;

use Illuminate\Support\ServiceProvider;

class ApiDoctorProvider extends ServiceProvider
{
/**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'api-doctor-swagger');
    }

}
