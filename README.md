# Filament Liquid Glass — by Osama

A deep **Liquid Glass theme + configurable chrome** for [Filament v5](https://filamentphp.com) panels. Add it with one line, then customize the art behind the glass, the glass itself, and the sidebar/topbar layout from config — no CSS build step required.

**By [Osama Mohammed Elnagar](https://github.com/OsamaElnagar)** · [github.com/OsamaElnagar/filament-liquid-glass](https://github.com/OsamaElnagar/filament-liquid-glass)

```
composer require osamaelnagar/filament-liquid-glass
```

```php
// app/Providers/Filament/AdminPanelProvider.php
use Osama\FilamentLiquidGlass\LiquidGlassPlugin;

return $panel
    ->plugin(LiquidGlassPlugin::make())
    // ...
```

> The theme is shipped as **plain CSS** (no Tailwind build on the consumer side) and served by the package's own cacheable route. The plugin links it from **only the panel that registered it**, so installing the package in a multi-panel app does not leak the theme onto other panels. It overrides Filament's layered stylesheet with unlayered rules.

---

## What you get

- Glass surfaces for the whole panel: sidebar, topbar, pages, cards/sections, tables, stats, modals, dropdowns/popovers, form fields, badges, tabs, pagination, callouts, rich editor, file upload, lazy skeletons.
- Ambient **art behind the glass**, driven by config:
  - `aurora` — drifting colour blobs (default),
  - `image` — one or more artworks, with dark/light variants and overlays,
  - `video` — a muted looping video layer,
  - `html` / `view` — **any custom objects** (SVG shapes, rings, floating orbs, particles, a canvas…),
  - `layers` — an ordered stack mixing all of the above.
- **Floating / isolated sidebar** with margin + radius, plus collapsible-on-desktop modes.
- **Floating or attached topbar**, sticky or scroll-away, with responsive fallbacks on mobile.
- Dark + light token sets, grain, reduced-motion/reduced-transparency/print fallbacks, and popover stacking fixes (the `backdrop-filter` traps).
- Optional branding + Filament palette helpers.

---

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=filament-liquid-glass-config
```

…or pass overrides inline (merged deep over the package config; no publish needed):

```php
->plugin(LiquidGlassPlugin::make([
    'sidebar' => ['floating' => true, 'margin' => 12],
]))
```

### Minimal config

```php
return [
    'enabled' => true,

    'theme' => [
        'dark_mode' => true,
        'default_mode' => 'dark',   // dark | light | system
        'switcher' => true,
    ],

    'sidebar' => [
        'floating' => true,          // detached, margined, rounded (desktop)
        'margin' => 14,
        'radius' => 26,
        'collapsible' => true,       // Filament desktop collapse
        'fully_collapsible' => false,
        'width' => null,             // e.g. '18rem'
        'collapsed_width' => null,   // e.g. '4.5rem'
    ],

    'topbar' => [
        'mode' => 'floating',        // attached | floating
        'margin' => 14,
        'radius' => 20,
        'sticky' => true,            // false → scrolls away with the page
    ],
];
```

### 1. Custom art: a single image with dark/light variants

```php
'ambient' => [
    'driver' => 'image',
    'image' => [
        'url_dark' => '/images/glass/art-night.jpg',
        'url_light' => '/images/glass/art-day.jpg',
        'opacity' => 0.7,
        'blur' => 0,
        'scale' => 1.02,
        'fit' => 'cover',
        'position' => 'center',
        'overlay_dark' => 'linear-gradient(180deg, rgb(5 8 23 / .1), rgb(5 8 23 / .85))',
        'overlay_light' => 'linear-gradient(180deg, rgb(255 255 255 / .05), rgb(255 255 255 / .4))',
    ],
    'grain' => ['enabled' => true, 'opacity' => 0.05],
],
```

A single `url` is used for both modes. The image is rendered as `position: fixed` art behind the UI (not a CSS background), so it keeps aspect/cover behaviour and gets blurred only if you ask.

### 2. Custom objects: your own HTML/SVG art layer

```php
'ambient' => [
    'driver' => 'layers',
    'layers' => [
        ['type' => 'image', 'url' => '/images/glass/vignette.svg', 'opacity' => .8],
        ['type' => 'aurora', 'colors' => ['#5b4bff', '#14c9de', '#ff5fbf'], 'strength' => .3],
        [
            'type' => 'html',
            'class' => 'my-art-layer',
            'html' => <<<'HTML'
                <div style="position:absolute;left:8%;top:20%;width:220px;height:220px;border-radius:9999px;
                            background:radial-gradient(circle at 30% 30%,rgba(255,255,255,.35),transparent 65%);
                            filter:blur(18px);"></div>
            HTML,
        ],
    ],
],
```

`html` is rendered raw (trusted config). Prefer a `view` layer for anything longer:

```php
['type' => 'view', 'view' => 'glass.art', 'data' => ['rings' => 3]],
```

…and render whatever you want in `resources/views/glass/art.blade.php` (inline styles, SVG, `<canvas>` + a small script, etc.). Keep it `pointer-events: none`.

A full layer list is possible; each entry supports:

| type | options |
|---|---|
| `aurora` | `colors`, `strength`, `blur` |
| `image` | `url`, `url_dark`, `url_light`, `opacity`, `blur`, `scale`, `fit`, `position`, `overlay` |
| `video` | `url`, `poster`, `opacity`, `blur` |
| `html` | `html`, `class` |
| `view` | `view`, `data` |

### 3. Replace the whole ambient layer

```php
'ambient' => ['view' => 'glass.aurora-custom'],
```

### 4. Glass tuning

```php
'glass' => [
    'blur' => 24,               // px
    'saturation' => 180,        // %
    'brightness' => 1.12,
    'dark_tint' => 0.065,       // white alpha over dark art (lower = clearer glass)
    'light_tint' => 0.58,
    'radius' => 24,
    'popover_opacity' => 0.975, // near-opaque popovers (required for legibility)
],
```

The palette is **not** part of the glass config — the theme reads the panel's `->colors()` so it always follows your brand. The package also exposes `LiquidGlassPlugin::defaultPalette()` as a convenience.

### 5. Branding

```php
'branding' => [
    'brand_name' => 'Glass Atelier',
    'logo' => '/images/logo.svg',      // URL, or raw <svg>…</svg> string
    'dark_logo' => null,
    'logo_height' => '2rem',
],
```

---

## Responsive behaviour

- Floating sidebar/topbar are **desktop-only** (`min-width: 1024px`); on mobile Filament's standard full-bleed chrome is used (no wasted margins, no clipped drawers).
- Glass blur is capped on `< 1024px` for performance (`--lg-glass-blur` is reduced by the stylesheet).
- Ambient motion is disabled by `prefers-reduced-motion`; blur/transparency degrade gracefully with `prefers-reduced-transparency`, `@supports not (backdrop-filter)`, and print.
- Sidebar collapse state is handled by Filament; the floating margins/radius persist for both expanded and collapsed rails.

---

## How it is wired (for maintainers)

```
src/LiquidGlassPlugin.php          panel-injected: head CSS link, render hooks, panel options
src/LiquidGlassServiceProvider.php config + views + publish tags + CSS route
resources/css/liquid-glass.css     plain unlayered CSS (served by ThemeCssController)
resources/views/ambient.blade.php  art layers: aurora/image/video/html/view/layers
resources/views/style.blade.php    config → CSS variables + floating chrome rules (STYLES_AFTER)
config/filament-liquid-glass.php   documented defaults
src/Http/Controllers/ThemeCssController.php  panel-scoped, long-cached stylesheet route
```

Order of loading: Filament's stock stylesheet (layered) → package CSS `<link>` from the panel `HEAD_END` hook (unlayered, wins) → the `STYLES_AFTER` config style (wins over both). That is why overrides work without `!important`.

**Accessibility / performance notes**

- Keep `pointer-events: none` on custom art.
- Don't put `backdrop-filter` on `.fi-body`/`.fi-layout` (fixed sidebar/modals would re-anchor); the package only blurs leaf surfaces.
- Large full-screen videos/images cost GPU; prefer compressed art and the default aurora for low-end devices.
- Popovers are intentionally near-opaque: a `backdrop-filter` element inside another cannot sample the page (nested backdrop roots).

## Publishing

- Config: `php artisan vendor:publish --tag=filament-liquid-glass-config`
- Views (to override ambient/style): `php artisan vendor:publish --tag=filament-liquid-glass-views`
- CSS is served by the package route `vendor/filament-liquid-glass/theme.css` (long-cache headers, versioned by file mtime); no publish/copy step is required. If you use a strict CSP, allow `style-src 'self'`.

## Requirements

- PHP `^8.2`, Filament `^5.0`
- No npm/Tailwind build required in the host app
- The theme is a panel plugin, not a full app template; pages/resources remain yours.

MIT licensed.

## Releasing

The package is plain PHP/CSS/Blade — no build step. To publish it:

1. Move it to its own repository (or a monorepo package path) and tag a semver release (`v1.0.0`); Packagist reads tags.
2. Submit **[github.com/OsamaElnagar/filament-liquid-glass](https://github.com/OsamaElnagar/filament-liquid-glass)** at [packagist.org](https://packagist.org/packages/submit) so `composer require osamaelnagar/filament-liquid-glass` works without a VCS entry. Until then, consumers can add it as a VCS repository:

```json
"repositories": [{ "type": "vcs", "url": "https://github.com/OsamaElnagar/filament-liquid-glass" }],
"require": { "osamaelnagar/filament-liquid-glass": "^1.0" }
```
3. In this repo it is consumed through a path repository:

```json
"repositories": [{ "type": "path", "url": "packages/filament-liquid-glass", "options": { "symlink": true } }],
"require": { "osamaelnagar/filament-liquid-glass": "@dev" }
```

4. Run the package tests (`tests/Feature/LiquidGlassPackageTest.php`) and the browser QA harness (`tools/theme-qa`) against the `/glass` demo panel before tagging.
5. If you change `resources/css/liquid-glass.css`, bump the package version — the stylesheet URL is cache-busted by file mtime, so consumers get the new file on deploy.

## Caveats

- Filament panel assets are registered application-wide; this package intentionally serves its CSS through a package route and links it from `HEAD_END` on the registering panel only. Don't replace that with `Css::make()` unless you're okay with the CSS loading on every panel.
- The package does not publish or override Filament vendor views.
- It does not force a palette; pass `->colors()` on the panel (or set `palette` in config) as usual.
- Custom art config values are trusted server-side config (raw HTML/view layers are rendered as-is).
