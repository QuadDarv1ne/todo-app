<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Выполняем миграции перед каждым тестом
        $this->artisan('migrate:fresh');
    }
}
