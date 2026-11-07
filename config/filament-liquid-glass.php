<?php

/*
 * Liquid Glass — package configuration.
 *
 * Publish this file into the host application with:
 *   php artisan vendor:publish --tag=filament-liquid-glass-config
 *
 * Everything can also be overridden per-panel (without publishing) by passing
 * an array to the plugin:
 *   ->plugin(LiquidGlassPlugin::make(['sidebar' => ['floating' => true]]))
 *
 * The palette is intentionally NOT configured here: the theme inherits the
 * panel's ->colors() so it never fights the host application's brand.
 */

return [
    'enabled' => true,

    'theme' => [
        'dark_mode' => true,
        'default_mode' => 'dark',   // dark | light | system
        'switcher' => true,
    ],

    // Optional Filament colour palette override (Color::Violet etc. or OKLCH arrays).
    'palette' => null,

    'branding' => [
        'brand_name' => null,
        'logo' => null,             // URL, or raw inline SVG/HTML string
        'dark_logo' => null,
        'logo_height' => null,      // e.g. '2rem'
    ],

    /*
    |--------------------------------------------------------------------------
    | Ambient "art" behind the glass
    |--------------------------------------------------------------------------
    |
    | driver:
    |   aurora  — the default drifting colour blobs
    |   image   — a background artwork (supports dark/light variants + overlay)
    |   layers  — ordered stack from `layers` (any mix of aurora/image/video/html/view)
    |   view    — render your own Blade view
    |   none    — flat glass without a backdrop (not recommended)
    */
    'ambient' => [
        'enabled' => true,
        'driver' => 'aurora',
        'view' => null,

        'aurora' => [
            'colors_dark' => ['#5b4bff', '#14c9de', '#ff5fbf', '#22d3a7'],
            'colors_light' => ['#b3a8ff', '#9be9f5', '#ffb9dd', '#a9f0d8'],
            'strength' => 0.48,
            'strength_light' => 0.42,
            'blur' => 44,
            'motion' => false, // opt-in: animating the big blurred layers forces continuous compositing/repainting
            'top_glow' => true,
        ],

        'image' => [
            'url' => null,          // e.g. '/images/glass/art-1.jpg' or a full URL
            'url_dark' => null,     // optional dark-mode artwork
            'url_light' => null,    // optional light-mode artwork
            'opacity' => 0.65,
            'blur' => 0,
            'scale' => 1.02,
            'fit' => 'cover',       // cover | contain | fill
            'position' => 'center', // CSS object-position
            'overlay' => null,      // shared overlay, e.g. 'linear-gradient(180deg, rgb(5 8 23 / .2), rgb(5 8 23 / .85))'
            'overlay_dark' => null, // dark-mode-only overlay (takes precedence over overlay)
            'overlay_light' => null, // light-mode-only overlay (takes precedence over overlay)
        ],

        /*
         * Advanced: an ordered stack of art layers. When not empty this takes
         * precedence over `driver` (except `view`).
         *
         * Layer shapes:
         *   ['type' => 'aurora', 'colors' => [...], 'strength' => 0.5, 'blur' => 60]
         *   ['type' => 'image',  'url' => '/images/art.jpg', 'opacity' => .5, 'blur' => 12, 'overlay' => '...']
         *   ['type' => 'video',  'url' => '/videos/art.mp4', 'poster' => '/images/poster.jpg', 'opacity' => .4]
         *   ['type' => 'html',   'html' => '<div class="my-shape"></div>', 'class' => 'my-art-layer']
         *   ['type' => 'view',   'view' => 'glass.art', 'data' => ['foo' => 'bar']]
         */
        'layers' => [],

        'grain' => [
            'enabled' => true,
            'opacity' => 0.05,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Glass tokens
    |--------------------------------------------------------------------------
    */
    'glass' => [
        'blur' => 24,               // px
        'saturation' => 180,        // %
        'brightness' => 1.12,
        'dark_tint' => 0.055,       // white alpha over the dark ambient
        'light_tint' => 0.42,
        'radius' => 24,             // px (xl cards)
        'radius_lg' => 18,
        'radius_md' => 12,
        'popover_opacity' => 0.975, // near-opaque popovers (nested backdrop roots)
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | floating  — detached, margined, rounded glass rail (desktop only)
    | collapsible / fully_collapsible — enable Filament's desktop collapse
    | width / collapsed_width — CSS lengths passed to the panel API
    */
    'sidebar' => [
        'floating' => true,
        'margin' => 14,
        'radius' => 26,
        'collapsible' => true,
        'fully_collapsible' => false,
        'width' => null,            // e.g. '18rem'
        'collapsed_width' => null,  // e.g. '4.5rem'
    ],

    /*
    |--------------------------------------------------------------------------
    | Topbar / header navigation
    |--------------------------------------------------------------------------
    |
    | mode: attached | floating
    | sticky: true|false (floating mode keeps its margins either way)
    */
    'topbar' => [
        'mode' => 'floating',
        'margin' => 14,
        'radius' => 20,
        'sticky' => true,
    ],
];
