# Changelog

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
