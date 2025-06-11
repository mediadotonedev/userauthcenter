<?php

namespace Mediadotonedev\UserAuthCenter;

use Illuminate\Support\ServiceProvider;

class UserAuthCenterServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge configuration file from package to application's config directory
        $this->mergeConfigFrom(__DIR__ . '/config/userauthcenter.php', 'userauthcenter');
    }

    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/config/userauthcenter.php' => config_path('userauthcenter.php'),
        ], 'userauthcenter-config');

        // Publish migrations files
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'userauthcenter-migrations');

        // --- Publishing other files (as per your request, assuming you want them to be editable) ---

        // Publish Controllers
        // Path adjusted based on your file structure: userauthcenter/src/Http/Controllers/UserAuthController.php
        $this->publishes([
            __DIR__ . '/Http/Controllers/UserAuthController.php' => app_path('Http/Controllers/UserAuthController.php'),
        ], 'userauthcenter-controllers');

        // Publish Requests
        // Path adjusted based on your file structure, correcting "Requsts" to "Requests"
        $this->publishes([
            __DIR__ . '/Http/Requests/UserCheckRequest.php' => app_path('Http/Requests/UserCheckRequest.php'),
            __DIR__ . '/Http/Requests/UserRegisterRequest.php' => app_path('Http/Requests/UserRegisterRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginPasswordRequest.php' => app_path('Http/Requests/UserLoginPasswordRequest.php'),
            __DIR__ . '/Http/Requests/UserRegisterVerifyRequest.php' => app_path('Http/Requests/UserRegisterVerifyRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginOtpRequest.php' => app_path('Http/Requests/UserLoginOtpRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginOtpVerifyRequest.php' => app_path('Http/Requests/UserLoginOtpVerifyRequest.php'),
        ], 'userauthcenter-requests');

        // Publish Rules
        // Path adjusted based on your file structure: userauthcenter/src/Rules/EmailOrIranianMobile.php
        $this->publishes([
            __DIR__ . '/Rules/EmailOrIranianMobile.php' => app_path('Rules/EmailOrIranianMobile.php'),
        ], 'userauthcenter-rules');

        // Publish Models (Use with caution for User model to avoid conflict with main App\Models\User)
        // Path adjusted based on your file structure: userauthcenter/src/Models/User.php
        $this->publishes([
            __DIR__ . '/Models/User.php' => app_path('Models/User.php'),
        ], 'userauthcenter-models', true);

        // --- NEW: Publish Services ---
        // Path adjusted based on your file structure: userauthcenter/src/Services/
        $this->publishes([
            __DIR__ . '/Services/UserAuthService.php' => app_path('Services/UserAuthService.php'),
            __DIR__ . '/Services/UserService.php' => app_path('Services/UserService.php'),
        ], 'userauthcenter-services');


        // --- Important: Routes handling ---
        // DO NOT publish the routes/userauthcenter_api.php file to routes/api.php of the main project.
        // Instead, load it directly from the package. This prevents overwriting the main project's routes.
        // Make sure you have renamed userauthcenter/src/routes/api.php to userauthcenter/src/routes/userauthcenter_api.php
        $this->loadRoutesFrom(__DIR__ . '/routes/userauthcenter_api.php'); // Changed filename here

        // Load migrations (essential for package functionality, not published)
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // --- Optional: A single tag for all publishes ---
        // If you define this, make sure all the paths are correct and match the individual publishes above.
        /*
        $this->publishes([
            __DIR__ . '/config/userauthcenter.php' => config_path('userauthcenter.php'),
            __DIR__ . '/database/migrations' => database_path('migrations'),
            __DIR__ . '/Http/Controllers/UserAuthController.php' => app_path('Http/Controllers/UserAuthController.php'),
            __DIR__ . '/Http/Requests/UserCheckRequest.php' => app_path('Http/Requests/UserCheckRequest.php'),
            __DIR__ . '/Http/Requests/UserRegisterRequest.php' => app_path('Http/Requests/UserRegisterRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginPasswordRequest.php' => app_path('Http/Requests/UserLoginPasswordRequest.php'),
            __DIR__ . '/Http/Requests/UserRegisterVerifyRequest.php' => app_path('Http/Requests/UserRegisterVerifyRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginOtpRequest.php' => app_path('Http/Requests/UserLoginOtpRequest.php'),
            __DIR__ . '/Http/Requests/UserLoginOtpVerifyRequest.php' => app_path('Http/Requests/UserLoginOtpVerifyRequest.php'),
            __DIR__ . '/Rules/EmailOrIranianMobile.php' => app_path('Rules/EmailOrIranianMobile.php'),
            __DIR__ . '/Models/User.php' => app_path('Models/User.php'),
            __DIR__ . '/Services/UserAuthService.php' => app_path('Services/UserAuthService.php'), // Added Services
            __DIR__ . '/Services/UserService.php' => app_path('Services/UserService.php'), // Added Services
            // DO NOT include routes file here if you don't want it to overwrite
            __DIR__ . '/config/l5-swagger.php' => config_path('l5-swagger.php'),
        ], 'userauthcenter-all');
        */
    }
}

