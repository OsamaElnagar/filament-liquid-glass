<?php

namespace Osama\FilamentLiquidGlass;

use Illuminate\Support\ServiceProvider;

class LiquidGlassServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/filament-liquid-glass.php',
            'filament-liquid-glass',
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-liquid-glass');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/filament-liquid-glass.php' => config_path('filament-liquid-glass.php'),
            ], 'filament-liquid-glass-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/filament-liquid-glass'),
            ], 'filament-liquid-glass-views');
        }
    }
}
