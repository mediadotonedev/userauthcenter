<?php

namespace Mediadotonedev\UserAuthCenter;

use Illuminate\Support\ServiceProvider;

class UserAuthCenterServiceProvider extends ServiceProvider
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
        ], 'userauthcenter-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'userauthcenter-migrations');

        // Publish routes
        $this->publishes([
            __DIR__ . '/routes/api.php' => base_path('routes/userauthcenter-api.php'),
        ], 'userauthcenter-routes');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\InstallCommand::class,
            ]);
        }
    }
}
