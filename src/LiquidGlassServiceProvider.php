<?php

namespace Osama\FilamentLiquidGlass;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Osama\FilamentLiquidGlass\Http\Controllers\ThemeCssController;

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

        /*
         * The stylesheet is served by the package itself instead of being
         * registered as a global Filament asset: Filament panel assets are
         * registered application-wide, which would leak this theme onto other
         * panels that use a different theme. The plugin links this route from
         * the panel that registered it only.
         */
        Route::get('vendor/filament-liquid-glass/theme.css', ThemeCssController::class)
            ->name('filament-liquid-glass.css');

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
