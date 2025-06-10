<?php

namespace Mediadotonedev\UserAuthCenter;

use Illuminate\Support\ServiceProvider;

class UserauthcenterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/userauthcenter.php', 'userauthcenter');
    }

    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/config/userauthcenter.php' => config_path('userauthcenter.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/apiuserauthcenter.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Publish Swagger configuration
        $this->publishes([
            __DIR__ . '/config/l5-swagger.php' => config_path('l5-swagger.php'),
        ], 'l5-swagger-config');
    }
}