@php
    $config = is_array($config ?? null) ? $config : [];

    $glass = is_array($config['glass'] ?? null) ? $config['glass'] : [];
    $ambient = is_array($config['ambient'] ?? null) ? $config['ambient'] : [];
    $aurora = is_array($ambient['aurora'] ?? null) ? $ambient['aurora'] : [];
    $image = is_array($ambient['image'] ?? null) ? $ambient['image'] : [];
    $sidebar = is_array($config['sidebar'] ?? null) ? $config['sidebar'] : [];
    $topbar = is_array($config['topbar'] ?? null) ? $config['topbar'] : [];

    $numeric = static fn (mixed $value, float $default): float => is_numeric($value) ? (float) $value : $default;
    $px = static fn (mixed $value, float $default): string => rtrim(rtrim(number_format($numeric($value, $default), 3, '.', ''), '0'), '.').'px';
    $pct = static fn (mixed $value, float $default): string => rtrim(rtrim(number_format($numeric($value, $default), 3, '.', ''), '0'), '.').'%';
    $cssColor = static function (mixed $value): ?string {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        // Defensive: colours are CSS values from trusted config; drop braces/semicolons.
        return preg_replace('/[;}{]/', '', trim($value));
    };
    $colors = static function (mixed $values): array {
        $values = array_values(array_slice((array) $values, 0, 4));

        while (count($values) < 4) {
            $values[] = end($values) ?: '#5b4bff';
        }

        return array_map(
            static fn (mixed $color): string => preg_replace('/[;}{]/', '', (string) $color),
            $values,
        );
    };

    $darkColors = $colors($aurora['colors_dark'] ?? ['#5b4bff', '#14c9de', '#ff5fbf', '#22d3a7']);
    $lightColors = $colors($aurora['colors_light'] ?? ['#b3a8ff', '#9be9f5', '#ffb9dd', '#a9f0d8']);

    $floatingSidebar = ($sidebar['floating'] ?? true) !== false;
    $floatingTopbar = (($topbar['mode'] ?? 'attached') === 'floating');
    $stickyTopbar = ($topbar['sticky'] ?? true) !== false;

    $sidebarMargin = $px($sidebar['margin'] ?? null, 14);
    $sidebarRadius = $px($sidebar['radius'] ?? null, 26);
    $topbarMargin = $floatingTopbar ? $px($topbar['margin'] ?? null, 14) : '0px';
    $topbarRadius = $px($topbar['radius'] ?? null, 20);

    $artOpacity = $numeric($image['opacity'] ?? null, 0.65);
    $artBlur = $px($image['blur'] ?? null, 0);
    $artScale = $numeric($image['scale'] ?? null, 1.02);
    $artFit = is_string($image['fit'] ?? null) ? $image['fit'] : 'cover';
    $artPosition = is_string($image['position'] ?? null) ? $image['position'] : 'center';

    $overlay = is_string($image['overlay'] ?? null) ? $image['overlay'] : '';

    $grain = is_array($ambient['grain'] ?? null) ? $ambient['grain'] : [];
    $grainOpacity = $numeric($grain['opacity'] ?? null, 0.05);

    $popoverOpacity = $numeric($glass['popover_opacity'] ?? null, 0.975);
@endphp

<style data-liquid-glass-style>
    :root {
        --lg-glass-blur: {{ $px($glass['blur'] ?? null, 24) }};
        --lg-glass-sat: {{ $pct($glass['saturation'] ?? null, 180) }};
        --lg-glass-bright: {{ $numeric($glass['brightness'] ?? null, 1.12) }};
        --lg-glass-alpha: {{ $numeric($glass['light_tint'] ?? null, 0.58) }};
        --lg-glass-border: rgb(255 255 255 / 0.75);
        --lg-glass-highlight: rgb(255 255 255 / 0.95);
        --lg-r-xl: {{ $px($glass['radius'] ?? null, 24) }};
        --lg-r-lg: {{ $px($glass['radius_lg'] ?? null, 18) }};
        --lg-r-md: {{ $px($glass['radius_md'] ?? null, 12) }};

        --lg-aurora-1: {{ $lightColors[0] }};
        --lg-aurora-2: {{ $lightColors[1] }};
        --lg-aurora-3: {{ $lightColors[2] }};
        --lg-aurora-4: {{ $lightColors[3] }};
        --lg-aurora-strength: {{ $numeric($aurora['strength_light'] ?? null, 0.42) }};
        --lg-aurora-blur: {{ $px($aurora['blur'] ?? null, 56) }};

        --lg-art-opacity: {{ $artOpacity }};
        --lg-art-blur: {{ $artBlur }};
        --lg-art-scale: {{ $artScale }};
        --lg-art-fit: {{ $artFit }};
        --lg-art-position: {{ $artPosition }};
        @if ($overlay !== '')
            --lg-art-overlay: {{ $overlay }};
        @endif

        --lg-grain-opacity: {{ $grainOpacity }};
        --lg-popover-alpha: {{ $popoverOpacity }};

        --lg-sidebar-margin: {{ $sidebarMargin }};
        --lg-sidebar-radius: {{ $sidebarRadius }};
        --lg-topbar-margin: {{ $topbarMargin }};
        --lg-topbar-radius: {{ $topbarRadius }};
    }

    html.dark {
        --lg-glass-alpha: {{ $numeric($glass['dark_tint'] ?? null, 0.065) }};
        --lg-glass-border: rgb(255 255 255 / 0.14);
        --lg-glass-highlight: rgb(255 255 255 / 0.28);

        --lg-aurora-1: {{ $darkColors[0] }};
        --lg-aurora-2: {{ $darkColors[1] }};
        --lg-aurora-3: {{ $darkColors[2] }};
        --lg-aurora-4: {{ $darkColors[3] }};
        --lg-aurora-strength: {{ $numeric($aurora['strength'] ?? null, 0.48) }};
    }

    @if ($floatingTopbar)
        @media (min-width: 1024px) {
            .fi-topbar-ctn {
                padding: var(--lg-topbar-margin);
            }

            .fi-topbar {
                border: 1px solid var(--lg-glass-border);
                border-radius: var(--lg-topbar-radius);
                /* No overflow clipping: the user-menu dropdown renders inside
                   the topbar's stacking context and would be cut off. */
            }
        }
    @endif

    @if (! $stickyTopbar)
        .fi-topbar-ctn {
            position: static;
        }
    @endif

    @if ($floatingSidebar)
        @media (min-width: 1024px) {
            .fi-sidebar {
                margin: var(--lg-sidebar-margin);
                border: 1px solid var(--lg-glass-border);
                border-radius: var(--lg-sidebar-radius);
            }

            .fi-body-has-topbar .fi-sidebar {
                top: calc(var(--topbar-height) + (2 * var(--lg-topbar-margin)) + var(--lg-sidebar-margin));
                height: calc(100dvh - var(--topbar-height) - (2 * var(--lg-topbar-margin)) - (2 * var(--lg-sidebar-margin)));
            }

            .fi-body:not(.fi-body-has-topbar) .fi-sidebar {
                top: var(--lg-sidebar-margin);
                height: calc(100dvh - (2 * var(--lg-sidebar-margin)));
            }

            @if (! $stickyTopbar)
                .fi-body-has-topbar .fi-sidebar {
                    top: var(--lg-sidebar-margin);
                }
            @endif
        }
    @endif

    @if (($config['ambient']['aurora']['motion'] ?? true) === false)
        .lg-ambient__blob {
            animation: none;
        }
    @endif
</style>
