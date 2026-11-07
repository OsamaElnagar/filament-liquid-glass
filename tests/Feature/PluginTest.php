<?php

namespace Osama\FilamentLiquidGlass\Tests\Feature;

use Osama\FilamentLiquidGlass\LiquidGlassPlugin;
use Osama\FilamentLiquidGlass\Tests\TestCase;

class PluginTest extends TestCase
{
    public function test_it_exposes_a_package_specific_plugin_id(): void
    {
        $this->assertSame('osamaelnagar/filament-liquid-glass', LiquidGlassPlugin::make()->getId());
    }

    public function test_make_deep_merges_overrides_over_the_package_config(): void
    {
        $plugin = LiquidGlassPlugin::make([
            'sidebar' => ['margin' => 7],
            'ambient' => ['image' => ['url' => '/images/art.jpg']],
        ]);

        $config = $plugin->getConfig();

        $this->assertSame(7, $config['sidebar']['margin']);
        $this->assertSame(26, $config['sidebar']['radius']);
        $this->assertSame('/images/art.jpg', $config['ambient']['image']['url']);
        $this->assertSame('aurora', $config['ambient']['driver']);
    }

    public function test_using_merges_multiple_calls(): void
    {
        $plugin = LiquidGlassPlugin::make(['sidebar' => ['margin' => 7]])
            ->using(['topbar' => ['mode' => 'attached']]);

        $config = $plugin->getConfig();

        $this->assertSame(7, $config['sidebar']['margin']);
        $this->assertSame('attached', $config['topbar']['mode']);
    }

    public function test_the_packaged_css_asset_exists_and_contains_the_glass_rules(): void
    {
        $path = (new LiquidGlassPlugin)->getCssPath();

        $this->assertFileExists($path);
        $this->assertStringContainsString('.lg-ambient', file_get_contents($path));
        $this->assertStringContainsString('.fi-sidebar', file_get_contents($path));
    }

    public function test_the_style_view_maps_config_to_tokens_and_floating_chrome(): void
    {
        $html = view('filament-liquid-glass::style', [
            'config' => [
                'glass' => ['blur' => 30, 'radius' => 28],
                'sidebar' => ['floating' => true, 'margin' => 12, 'radius' => 22],
                'topbar' => ['mode' => 'floating', 'margin' => 10, 'radius' => 18, 'sticky' => true],
            ],
        ])->render();

        $this->assertStringContainsString('--lg-glass-blur: 30px', $html);
        $this->assertStringContainsString('--lg-r-xl: 28px', $html);
        $this->assertStringContainsString('--lg-sidebar-margin: 12px', $html);
        $this->assertStringContainsString('--lg-topbar-margin: 10px', $html);
        $this->assertStringContainsString('.fi-sidebar', $html);
        $this->assertStringContainsString('.fi-topbar-ctn', $html);
    }

    public function test_the_ambient_view_renders_html_image_and_view_layers(): void
    {
        $html = view('filament-liquid-glass::ambient', [
            'config' => [
                'ambient' => [
                    'driver' => 'layers',
                    'layers' => [
                        ['type' => 'aurora', 'colors' => ['#111111', '#222222', '#333333']],
                        ['type' => 'image', 'url' => '/images/art.jpg', 'opacity' => 0.5],
                        ['type' => 'html', 'html' => '<div id="custom-object">shape</div>'],
                    ],
                    'grain' => ['enabled' => true, 'opacity' => 0.04],
                ],
            ],
        ])->render();

        $this->assertStringContainsString('lg-ambient__aurora', $html);
        $this->assertStringContainsString('/images/art.jpg', $html);
        $this->assertStringContainsString('custom-object', $html);
        $this->assertStringContainsString('data-liquid-glass-grain', $html);
    }

    public function test_the_ambient_view_can_be_disabled(): void
    {
        $html = view('filament-liquid-glass::ambient', [
            'config' => ['ambient' => ['enabled' => false]],
        ])->render();

        $this->assertSame('', trim($html));
    }

    public function test_ambient_motion_is_opt_in(): void
    {
        $static = view('filament-liquid-glass::style', [
            'config' => ['ambient' => ['aurora' => ['motion' => false]]],
        ])->render();

        $this->assertStringNotContainsString('animation-name: lg-drift', $static);

        $animated = view('filament-liquid-glass::style', [
            'config' => ['ambient' => ['aurora' => ['motion' => true]]],
        ])->render();

        $this->assertStringContainsString('animation-name: lg-drift', $animated);
    }
}
