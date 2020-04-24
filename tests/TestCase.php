<?php

namespace Crudly\Encrypted\Tests;

use Crudly\Encrypted\Provider;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return Crudly\Connectly\Provider
     */
    protected function getPackageProviders($app)
    {
        return [Provider::class];
    }
}
