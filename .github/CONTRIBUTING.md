# Contributing to Filament Liquid Glass

Thanks for considering a contribution! Please open an issue for significant changes before opening a pull request so we can agree on the approach.

## Process

1. Fork the repository.
2. Create a focused branch.
3. Add or update tests.
4. Run the package checks locally.
5. Open a pull request describing the behaviour change and any visual impact.

## Local setup

```bash
composer install
```

The package runs against Orchestra Testbench, so the full suite is self-contained.

## Checks

```bash
composer lint        # format
composer lint:check  # format check
composer analyse     # PHPStan / Larastan
composer test        # PHPUnit
composer check       # analyse + pint --test + phpunit
```

Visual and integration coverage lives in the host application in `tests/Feature/LiquidGlassPackageTest.php` and the theme QA harness under `tools/theme-qa/`; include before/after screenshots for visual changes.

## Guidelines

- Keep the package panel-scoped: registering the plugin must not change panels that did not boot it.
- Keep CSS unlayered so it continues to beat Filament's layered theme CSS.
- Prefer configuration keys over hard-coded consumer-specific values.
- Follow SemVer. Breaking visual/config changes require a major version.
- Keep commits coherent and use conventional commit-style summaries where practical.

Please report security issues privately as described in [SECURITY.md](../SECURITY.md).
