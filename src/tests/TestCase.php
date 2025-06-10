<?php

namespace Mohsen\UserAuthCenter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Mohsen\UserAuthCenter\UserauthcenterServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [UserauthcenterServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}