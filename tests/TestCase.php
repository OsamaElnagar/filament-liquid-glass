<?php

namespace Osama\FilamentLiquidGlass\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Osama\FilamentLiquidGlass\LiquidGlassServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LiquidGlassServiceProvider::class,
        ];
    }
}
