<?php

namespace Osama\FilamentLiquidGlass;

use Filament\Contracts\Plugin;
use Filament\Enums\ThemeMode;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

/**
 * Panel plugin for the Liquid Glass theme.
 *
 * Everything is optional and config-driven; the plugin only touches the panel
 * it is registered on (render hooks/assets are panel-scoped, so installing the
 * package does not affect other panels).
 *
 *   ->plugin(LiquidGlassPlugin::make())
 *   ->plugin(LiquidGlassPlugin::make(['sidebar' => ['floating' => true]]))
 */
class LiquidGlassPlugin implements Plugin
{
    /** @var array<string, mixed> */
    protected array $overrides = [];

    /**
     * @param  array<string, mixed>  $overrides  Deep-merged over the package config.
     */
    public static function make(array $overrides = []): static
    {
        return app(static::class)->using($overrides);
    }

    /**
     * Access the plugin instance/config from anywhere after the panel boots.
     */
    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    /**
     * @param  array<string, mixed>  $overrides  Deep-merged over the current overrides.
     */
    public function using(array $overrides): static
    {
        $this->overrides = array_replace_recursive($this->overrides, $overrides);

        return $this;
    }

    public function getId(): string
    {
        return 'osamaelnagar/filament-liquid-glass';
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        /** @var array<string, mixed> $config */
        $config = config('filament-liquid-glass', []);

        if ($this->overrides === []) {
            return $config;
        }

        return array_replace_recursive($config, $this->overrides);
    }

    public function register(Panel $panel): void
    {
        $config = $this->getConfig();

        if (! ($config['enabled'] ?? true)) {
            return;
        }

        $this->registerPanelOptions($panel, $config);

        // Panel assets: Filament only loads these on the panel that booted the
        // plugin (verified in Filament 5.11), so other panels keep their theme.
        $panel->assets([
            Css::make('liquid-glass', $this->getCssPath()),
        ], package: 'osamaelnagar/filament-liquid-glass');

        $panel->renderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => view('filament-liquid-glass::ambient', ['config' => $this->getConfig()])->render(),
        );

        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            fn (): string => view('filament-liquid-glass::style', ['config' => $this->getConfig()])->render(),
        );
    }

    public function boot(Panel $panel): void {}

    public function getCssPath(): string
    {
        return dirname(__DIR__).'/resources/css/liquid-glass.css';
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function registerPanelOptions(Panel $panel, array $config): void
    {
        $theme = $config['theme'] ?? [];

        if (($theme['dark_mode'] ?? true) === false) {
            $panel->darkMode(false);
        } else {
            $panel->darkMode(true);

            if (is_string($theme['default_mode'] ?? null)) {
                $mode = ThemeMode::tryFrom($theme['default_mode']);

                if ($mode) {
                    $panel->defaultThemeMode($mode);
                }
            }

            if (($theme['switcher'] ?? true) === false) {
                $panel->themeSwitcher(false);
            }
        }

        $sidebar = $config['sidebar'] ?? [];

        if (($sidebar['fully_collapsible'] ?? false) === true) {
            $panel->sidebarFullyCollapsibleOnDesktop();
        } elseif (($sidebar['collapsible'] ?? false) === true) {
            $panel->sidebarCollapsibleOnDesktop();
        }

        if (is_string($sidebar['width'] ?? null)) {
            $panel->sidebarWidth($sidebar['width']);
        }

        if (is_string($sidebar['collapsed_width'] ?? null)) {
            $panel->collapsedSidebarWidth($sidebar['collapsed_width']);
        }

        if (is_array($config['palette'] ?? null)) {
            $panel->colors($config['palette']);
        }

        $branding = $config['branding'] ?? [];

        if (is_string($branding['brand_name'] ?? null)) {
            $panel->brandName($branding['brand_name']);
        }

        if (filled($branding['logo'] ?? null)) {
            $panel->brandLogo(fn (): string|Htmlable => $this->normalizeLogo($branding['logo']));
        }

        if (filled($branding['dark_logo'] ?? null)) {
            $panel->darkModeBrandLogo(fn (): string|Htmlable => $this->normalizeLogo($branding['dark_logo']));
        }

        if (is_string($branding['logo_height'] ?? null)) {
            $panel->brandLogoHeight($branding['logo_height']);
        }
    }

    protected function normalizeLogo(mixed $logo): string|Htmlable
    {
        if ($logo instanceof Htmlable) {
            return $logo;
        }

        $logo = (string) $logo;

        return str_starts_with(ltrim($logo), '<') ? new HtmlString($logo) : $logo;
    }

    /**
     * Helper for configs that want Filament's built-in palettes.
     *
     * @return array<string, mixed>
     */
    public static function defaultPalette(): array
    {
        return [
            'primary' => Color::Violet,
            'gray' => Color::Slate,
            'info' => Color::Sky,
            'success' => Color::Emerald,
            'warning' => Color::Amber,
            'danger' => Color::Rose,
        ];
    }
}
