<p align="center">
  <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/cover.jpg" alt="Filament Liquid Glass — the same panel split diagonally between the dark and light themes" width="100%">
</p>

<h1 align="center">Filament Liquid Glass</h1>

<p align="center">
  <strong>A deeply configurable liquid-glass theme for <a href="https://filamentphp.com">Filament v5</a> panels.</strong><br>
  Ambient art behind the glass · floating sidebar · floating or sticky topbar · dark + light · zero build step.
</p>

<p align="center">
  <a href="https://packagist.org/packages/osamaelnagar/filament-liquid-glass"><img src="https://img.shields.io/packagist/v/osamaelnagar/filament-liquid-glass?style=flat-square&color=6f7dff" alt="Latest version"></a>
  <a href="https://packagist.org/packages/osamaelnagar/filament-liquid-glass"><img src="https://img.shields.io/packagist/dt/osamaelnagar/filament-liquid-glass?style=flat-square&color=14c9de" alt="Total downloads"></a>
  <a href="https://github.com/OsamaElnagar/filament-liquid-glass"><img src="https://img.shields.io/badge/Filament-v5-b6aaff?style=flat-square" alt="Filament v5"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-22d3a7?style=flat-square" alt="MIT license"></a>
  <a href="https://github.com/OsamaElnagar/filament-liquid-glass/stargazers"><img src="https://img.shields.io/github/stars/OsamaElnagar/filament-liquid-glass?style=flat-square&color=ff9bd6" alt="GitHub stars"></a>
  <a href="https://github.com/OsamaElnagar/filament-liquid-glass/actions/workflows/tests.yml"><img src="https://github.com/OsamaElnagar/filament-liquid-glass/actions/workflows/tests.yml/badge.svg" alt="Tests"></a>
  <a href="https://packagist.org/packages/osamaelnagar/filament-liquid-glass"><img src="https://img.shields.io/badge/Laravel-11--13-ff2d20?style=flat-square" alt="Laravel 11–13"></a>
</p>

<p align="center">
  By <a href="https://github.com/OsamaElnagar"><strong>Osama Mohammed Elnagar</strong></a> · <a href="https://github.com/OsamaElnagar/filament-liquid-glass">GitHub</a> · <a href="https://packagist.org/packages/osamaelnagar/filament-liquid-glass">Packagist</a>
</p>

---

## Install

```bash
composer require osamaelnagar/filament-liquid-glass
php artisan filament:assets
```

```php
// app/Providers/Filament/AdminPanelProvider.php
use Osama\FilamentLiquidGlass\LiquidGlassPlugin;

return $panel
    ->plugin(LiquidGlassPlugin::make())
    // ...
```

That's the zero-config setup: the theme, ambient art, and glass surfaces are all wired automatically. `filament:assets` publishes the panel CSS to `public/css/osamaelnagar/filament-liquid-glass/`; re-run it after package updates.

Want to customize? Publish the config (or pass overrides inline — see [Configuration](#configuration)):

```bash
php artisan vendor:publish --tag=filament-liquid-glass-config
```

> Served as **plain CSS** — no Tailwind/npm build in your app. It's registered as a panel asset, so Filament only loads it on the panel that uses the plugin.

---

## Screenshots

<table>
  <tr>
    <td align="center" width="50%">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/dashboard-dark.jpg" alt="Dark dashboard with a floating glass sidebar, floating topbar and ambient art">
      <br><sub><b>Dark</b> — floating sidebar + topbar over ambient art</sub>
    </td>
    <td align="center" width="50%">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/dashboard-light.jpg" alt="Light dashboard with a floating glass sidebar, floating topbar and pastel ambient art">
      <br><sub><b>Light</b> — same panel, pastel art and milk glass</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/login-dark.jpg" alt="Glass sign-in card over a dark nebula artwork">
      <br><sub><b>Sign-in</b> — image artwork + custom SVG objects behind the glass</sub>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/dropdown-dark.jpg" alt="User menu dropdown open over the glass topbar">
      <br><sub><b>Menus & popovers</b> — nested glass that stays legible</sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/collapsed-dark.jpg" alt="Collapsed floating sidebar rail with only icons">
      <br><sub><b>Collapsed rail</b> — margins and radius survive the collapse</sub>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/theme-switcher.jpg" alt="Theme switcher open in the topbar">
      <br><sub><b>Dark ⇄ Light</b> — token sets for both modes</sub>
    </td>
  </tr>
</table>

<p align="center">
  <img src="https://cdn.jsdelivr.net/gh/OsamaElnagar/filament-liquid-glass@main/art/screenshots/mobile-dark.jpg" alt="Mobile layout on a narrow screen with full-bleed chrome" width="300">
  <br><sub><b>Mobile</b> — floating chrome steps aside; full-bleed Filament layout</sub>
</p>

---

## What you get

- Glass surfaces for the whole panel: sidebar, topbar, pages, cards/sections, tables, stats, modals, dropdowns/popovers, form fields, badges, tabs, pagination, callouts, rich editor, file upload, lazy skeletons.
- Ambient **art behind the glass**, driven by config:
  - `aurora` — colour blobs (static by default; enable `ambient.aurora.motion` to drift them),
  - `image` — one or more artworks, with dark/light variants and per-mode overlays,
  - `video` — a muted looping video layer,
  - `html` / `view` — **any custom objects** (SVG shapes, rings, floating orbs, particles, a canvas…),
  - `layers` — an ordered stack mixing all of the above.
- **Liquid-glass material:** clear light glass with a spectral rim, top-edge specular sheen and adaptive tint; smoky dark glass with a luminous edge. True optical refraction is approximated in CSS (see [Performance](#performance)).
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
    'dark_tint' => 0.055,       // white alpha over dark art (lower = clearer glass)
    'light_tint' => 0.42,
    'radius' => 24,
    'popover_opacity' => 0.975, // near-opaque popovers (required for legibility)
    'surface_blur' => false,    // true = frost cards/tables too (photo backgrounds; GPU cost)
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

## Performance

- This is a **CSS approximation of Apple’s Liquid Glass**: translucency, saturation/blur where it matters, specular sheen, spectral rim and adaptive tint. True real-time **optical refraction/lensing** (content bending at the edges) requires SVG displacement or WebGL; that is deliberately not enabled by default because it is expensive and not reliably supported.

- **Ambient motion is opt-in** (`ambient.aurora.motion => true`). Animating four large blurred, blended layers keeps Chrome's compositor busy every frame, even when the page is idle — very noticeable on Windows and low-power GPUs. Static art keeps the same look with zero idle compositing.
- Keep the ambient layer static unless you specifically want motion; if you enable it, test on your target hardware.
- **Blur is limited to chrome + overlays** (sidebar, topbar, modals, dropdowns, the auth card). Cards, tables, stats and inputs use translucent tints + spectral rims instead — a blurred layer per card/table was the remaining GPU cost. Lower `glass.blur` (e.g. `16`) if chrome/overlays still feel heavy on low-end machines.
- Avoid large full-screen videos; a single image artwork is cheaper than animated blobs.

---

## How it is wired (for maintainers)

```
src/LiquidGlassPlugin.php          panel-injected: CSS asset, render hooks, panel options
src/LiquidGlassServiceProvider.php config + views + publish tags
resources/css/liquid-glass.css     plain unlayered CSS, registered as a panel asset
resources/views/ambient.blade.php  art layers: aurora/image/video/html/view/layers
resources/views/style.blade.php    config → CSS variables + floating chrome rules (STYLES_AFTER)
config/filament-liquid-glass.php   documented defaults

```

Order of loading: Filament's stock stylesheet (layered) → the package's panel CSS asset (unlayered, wins) → the `STYLES_AFTER` config style (wins over both). That is why overrides work without `!important`.

**Accessibility / performance notes**

- Keep `pointer-events: none` on custom art.
- Don't put `backdrop-filter` on `.fi-body`/`.fi-layout` (fixed sidebar/modals would re-anchor); the package only blurs leaf surfaces.
- Large full-screen videos/images cost GPU; prefer compressed art and the default aurora for low-end devices.
- Popovers are intentionally near-opaque: a `backdrop-filter` element inside another cannot sample the page (nested backdrop roots).

## Publishing

- Config: `php artisan vendor:publish --tag=filament-liquid-glass-config`
- Views (to override ambient/style): `php artisan vendor:publish --tag=filament-liquid-glass-views`
- Panel CSS is published with `php artisan filament:assets` into `public/css/osamaelnagar/filament-liquid-glass/`; re-run it after package updates.

## Requirements

- PHP `^8.2`, Filament `^5.0`
- No npm/Tailwind build required in the host app
- The theme is a panel plugin, not a full app template; pages/resources remain yours.

MIT licensed.

## Caveats

- Filament panel assets are registered per panel: the plugin uses `$panel->assets()` in `register()`, so panels that don't install the plugin never load the theme. Run `php artisan filament:assets` after install/update.
- The package does not publish or override Filament vendor views.
- It does not force a palette; pass `->colors()` on the panel (or set `palette` in config) as usual.
- Custom art config values are trusted server-side config (raw HTML/view layers are rendered as-is).
