# Changelog

## [1.6.0] - 2026-11-10

### Added

- Resizable glass textareas: native vertical drag-resize now grows the glass input shell with the field, and modern Chromium auto-expands populated textareas via `field-sizing: content`.
- Package hygiene: PHPStan/Larastan level 7, Pint config, `.editorconfig`, `.gitattributes` export rules, contributing guide, bug template, funding metadata, release notes and changelog automation.

### Fixed

- A resized textarea could grow outside its `.fi-input-wrp` glass shell instead of expanding the shell with it.


## [1.5.2] - 2026-11-08

### Enhanced

- Styled Filament's `stackedOnMobile()` table mode so stacked rows read as inset glass cards with muted uppercase labels and proper spacing.
- Kept stacked table styling inside the package stylesheet, ready for consumers who enable `Table::configureUsing(fn (Table $table) => $table->stackedOnMobile())` in their panel.


## [1.5.1] - 2026-11-08

### Fixed

- Mobile/RTL hardening: sections and their header/action areas are now shrinkable (`min-width: 0`, wrapping action rows) so long headers and table-report KPI blocks no longer force horizontal page overflow.
- Page-content direct children are allowed to shrink inside glass panels, preventing nested `auto-fit` grids from widening the page on 390px viewports.


## [1.5.0] - 2026-11-07

### Added

- `glass.profile` with a new `lens` material: variable-alpha glass, 28px blur, 180% saturation, dual specular inset rims, inner glow and dual outer shadows, inspired by the Claude Liquid Glass mockup.
- Paired `lens` demo panel with a high-contrast colored-object scene (`/glass-lens`) plus a light variant scene for light mode.
- Tests for the lens profile and the lens panel config.


## [1.4.0] - 2026-11-07

### Added

- `glass.surface_blur` (default `false`): opt-in frosted blur on cards, tables and stat surfaces. Best for photographic/full-bleed backgrounds; costs a composited blur layer per surface.
- Multi-panel showcase (separate app demo) exercising aurora, photographic sunset, nebula, custom objects and minimal presets.
- Increased light/dark muted-ink contrast for section descriptions, sidebar groups and table headers on photographic backgrounds.


## [1.3.0] - 2026-11-07

### Changed

- **Liquid Glass v2 material.** Light mode is much clearer and more luminous: lower white tint (`.42`), higher saturation, a broad top-left specular sheen, a cyan/pink spectral rim, stronger inner edge highlight and softer depth shadow. Dark mode gets the same edge treatment with a smoky low-alpha tint.
- Chrome (topbar/sidebar) is translucent with a subtle backdrop blur again; cards remain tint/rim-based for performance.
- Updated defaults: `glass.light_tint` `.58 → .42`, `glass.dark_tint` `.065 → .055`.


## [1.2.2] - 2026-11-07

### Fixed

- Aligned stats-overview widgets with the rest of the dashboard: removed the nested section content padding, forced a shrinkable section grid track, and removed header padding so headings, descriptions and stat cards share the page gutter on mobile and desktop.
- Prevented the stats description from forcing the section wider than the viewport at narrow widths.


## [1.2.1] - 2026-11-07

### Changed

- Limited `backdrop-filter` to overlays (modal, dropdown, auth card). Cards, tables, stats, inputs, badges and application chrome now use translucent tints instead; each blurred surface was a composited layer with little visible benefit over the already-soft ambient backdrop.
- Increased chrome/sidebar tint opacity slightly to compensate for the removed blur.
- Removed the full-screen blur from the modal backdrop and from callouts/empty states.
- Demo panel idle backdrop-filter surfaces: 17 → 2; active animations: 4 → 0.


## [1.2.0] - 2026-11-07

### Changed

- Ambient aurora is **static by default** for performance: animating four large blurred, blended fixed layers forces continuous compositor work even while idle (especially on Windows). Motion is now opt-in via `ambient.aurora.motion => true`.
- Reduced default aurora blur from 56/64px to 44/48px and removed `will-change` from static art.
- Documented the performance trade-off and the opt-in motion setting.


All notable changes to `osamaelnagar/filament-liquid-glass` are documented here.
The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.1] - 2026-11-04

### Added

- Explicit `illuminate/support` constraint (`^11.28|^12.0|^13.0`) so Laravel compatibility is part of the package metadata.
- Package test suite (Orchestra Testbench + PHPUnit) and a GitHub Actions CI matrix for PHP 8.3, 8.4 and 8.5.
- `SECURITY.md` and this `CHANGELOG.md`.

## [1.1.0] - 2026-11-04

### Changed

- Refactored to the official Filament panel-plugin pattern: CSS is registered with `$panel->assets()` inside the plugin's `register()` method instead of a custom route/`HEAD_END` link.
- Plugin ID is now package-specific: `osamaelnagar/filament-liquid-glass`.
- Added fluent config helpers: `LiquidGlassPlugin::using()`, `LiquidGlassPlugin::get()`.
- Install docs now run `php artisan filament:assets`.

### Removed

- `ThemeCssController` and the custom stylesheet route.

## [1.0.2] - 2026-11-04

### Added

- Marketing cover image and screenshot gallery in the README.

## [1.0.1] - 2026-11-04

### Changed

- Packagist vendor changed from `osama` (already claimed) to `osamaelnagar`.

## [1.0.0] - 2026-11-04

### Added

- Initial release: Liquid Glass theme for Filament v5 panels.
- Configurable ambient art layers: `aurora`, `image` (dark/light + overlays), `video`, `html`, `view`, and ordered `layers`.
- Floating/collapsible sidebar and floating/attached sticky topbar options.
- Dark + light token sets, glass surfaces, popovers, fallbacks, and responsive behaviour.
- Config + view publishing and per-panel overrides.
