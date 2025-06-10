<?php
namespace mediadotonedev\UserAuthCenter\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'userauthcenter:install';
    protected $description = 'Install the UserAuthCenter package';

    public function handle()
    {
        $this->info('Installing UserAuthCenter...');

        // انتشار فایل تنظیمات پکیج
        $this->call('vendor:publish', [
            '--provider' => 'Mohsen\UserAuthCenter\UserauthcenterServiceProvider',
            '--tag' => 'config',
        ]);

        // انتشار فایل تنظیمات L5-Swagger
        $this->call('vendor:publish', [
            '--provider' => 'Mohsen\UserAuthCenter\UserauthcenterServiceProvider',
            '--tag' => 'l5-swagger-config',
        ]);

        // انتشار مهاجرت‌های Sanctum
        $this->call('vendor:publish', [
            '--provider' => 'Laravel\Sanctum\SanctumServiceProvider',
            '--tag' => 'sanctum-migrations',
        ]);

        // اجرای مهاجرت‌ها
        $this->call('migrate');

        // تولید مستندات Swagger
        $this->call('l5-swagger:generate');

        $this->info('UserAuthCenter installed successfully!');
    }
}
