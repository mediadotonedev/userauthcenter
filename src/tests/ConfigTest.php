<?php

namespace Mohsen\UserAuthCenter\Tests;

class ConfigTest extends TestCase
{
    public function test_environment_variables_are_loaded()
    {
        $this->assertEquals('98|Kfgqg7LRo9sz08mBw4gzvIAbee50a2d', config('userauthcenter.api.key'));
        $this->assertEquals('http://127.0.0.1:8000/api/clients/', config('userauthcenter.api.url'));
    }
}