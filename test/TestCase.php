<?php

namespace Test;

use Takemo101\LaravelSimpleVM\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'simple-vm',
            [
                'namespace' => 'Http/ViewModel',
                'path' => dirname(__DIR__, 1) . '/app',
            ]
        );
    }
}
