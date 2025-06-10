<?php

namespace Mohsen\UserAuthCenter\Tests;

use Illuminate\Support\Facades\Schema;

class MigrationTest extends TestCase
{
    public function test_users_table_has_columns()
    {
        $this->artisan('migrate', ['--database' => 'testing']);

        $this->assertTrue(Schema::hasColumns('users', [
            'avatar', 'nickname', 'phone', 'phone_verified_at', 'birth_date', 'gender',
        ]));
    }
}