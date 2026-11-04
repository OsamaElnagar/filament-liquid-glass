@php
    $config = is_array($config ?? null) ? $config : [];
    $ambient = is_array($config['ambient'] ?? null) ? $config['ambient'] : [];

    $enabled = ($ambient['enabled'] ?? true) !== false;
    $driver = is_string($ambient['driver'] ?? null) ? $ambient['driver'] : 'aurora';
    $customView = is_string($ambient['view'] ?? null) && $ambient['view'] !== '' ? $ambient['view'] : null;
    $layers = is_array($ambient['layers'] ?? null) ? $ambient['layers'] : [];

    $aurora = is_array($ambient['aurora'] ?? null) ? $ambient['aurora'] : [];
    $image = is_array($ambient['image'] ?? null) ? $ambient['image'] : [];
    $grain = is_array($ambient['grain'] ?? null) ? $ambient['grain'] : [];

    $assetUrl = static function (?string $url): ?string {
        if ($url === null || trim($url) === '') {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '//')) {
            return $url;
        }

        return asset($url);
    };

    $numeric = static fn (mixed $value, float $default): float => is_numeric($value) ? (float) $value : $default;

    if ($customView === null && $layers === []) {
        $layers = match ($driver) {
            'image' => [['type' => 'image']],
            'none' => [],
            default => [['type' => 'aurora']],
        };
    }

    $grainEnabled = ($grain['enabled'] ?? true) !== false;
    $grainOpacity = $numeric($grain['opacity'] ?? null, 0.05);
@endphp

@if (! $enabled)
    {{-- Ambient layer disabled via config. --}}
@elseif ($customView !== null)
    {!! view($customView)->render() !!}
@elseif ($layers !== [])
    <div class="lg-ambient" aria-hidden="true" data-liquid-glass-ambient>
        @foreach ($layers as $layer)
            @php
                if (! is_array($layer)) {
                    continue;
                }

                $type = is_string($layer['type'] ?? null) ? $layer['type'] : 'aurora';
            @endphp

            @switch($type)
                @case('aurora')
                    @php
                        $colors = $layer['colors'] ?? $aurora['colors_dark'] ?? ['#5b4bff', '#14c9de', '#ff5fbf', '#22d3a7'];
                        $colors = array_values(array_slice((array) $colors, 0, 4));
                        $fallback = end($colors) ?: '#5b4bff';

                        while (count($colors) < 4) {
                            $colors[] = $fallback;
                        }

                        $strength = $numeric($layer['strength'] ?? null, $numeric($aurora['strength'] ?? null, 0.48));
                        $blur = $numeric($layer['blur'] ?? null, $numeric($aurora['blur'] ?? null, 56));
                    @endphp

                    <div
                        class="lg-ambient__layer lg-ambient__aurora"
                        style="--lg-aurora-1: {{ $colors[0] }}; --lg-aurora-2: {{ $colors[1] }}; --lg-aurora-3: {{ $colors[2] }}; --lg-aurora-4: {{ $colors[3] }}; --lg-aurora-strength: {{ $strength }}; --lg-aurora-blur: {{ $blur }}px;"
                    >
                        <span class="lg-ambient__blob lg-ambient__blob--a"></span>
                        <span class="lg-ambient__blob lg-ambient__blob--b"></span>
                        <span class="lg-ambient__blob lg-ambient__blob--c"></span>
                        <span class="lg-ambient__blob lg-ambient__blob--d"></span>
                    </div>
                    @break

                @case('image')
                    @php
                        $base = $layer['url'] ?? $image['url'] ?? null;
                        $dark = $layer['url_dark'] ?? $image['url_dark'] ?? $base;
                        $light = $layer['url_light'] ?? $image['url_light'] ?? $base;

                        $opacity = $numeric($layer['opacity'] ?? null, $numeric($image['opacity'] ?? null, 0.65));
                        $blur = $numeric($layer['blur'] ?? null, $numeric($image['blur'] ?? null, 0));
                        $scale = $numeric($layer['scale'] ?? null, $numeric($image['scale'] ?? null, 1.02));
                        $fit = is_string($layer['fit'] ?? null) ? $layer['fit'] : (is_string($image['fit'] ?? null) ? $image['fit'] : 'cover');
                        $position = is_string($layer['position'] ?? null) ? $layer['position'] : (is_string($image['position'] ?? null) ? $image['position'] : 'center');
                        $overlay = $layer['overlay'] ?? $image['overlay'] ?? null;
                        $overlayDark = $layer['overlay_dark'] ?? $image['overlay_dark'] ?? null;
                        $overlayLight = $layer['overlay_light'] ?? $image['overlay_light'] ?? null;
                    @endphp

                    @if (filled($dark) || filled($light))
                        <div
                            class="lg-ambient__layer lg-ambient__art"
                            style="--lg-art-opacity: {{ $opacity }}; --lg-art-blur: {{ $blur }}px; --lg-art-scale: {{ $scale }}; --lg-art-fit: {{ $fit }}; --lg-art-position: {{ $position }};"
                        >
                            @if (filled($dark))
                                <img
                                    class="lg-ambient__image lg-ambient__image--dark"
                                    src="{{ $assetUrl($dark) }}"
                                    alt=""
                                    loading="eager"
                                    fetchpriority="high"
                                    decoding="async"
                                />
                            @endif

                            @if (filled($light))
                                <img
                                    class="lg-ambient__image lg-ambient__image--light"
                                    src="{{ $assetUrl($light) }}"
                                    alt=""
                                    loading="eager"
                                    decoding="async"
                                />
                            @endif

                            @if (filled($overlay) || filled($overlayDark) || filled($overlayLight))
                                <div class="lg-ambient__overlay lg-ambient__overlay--dark" style="--lg-art-overlay: {{ filled($overlayDark) ? $overlayDark : $overlay }};"></div>
                                <div class="lg-ambient__overlay lg-ambient__overlay--light" style="--lg-art-overlay: {{ filled($overlayLight) ? $overlayLight : $overlay }};"></div>
                            @endif
                        </div>
                    @endif
                    @break

                @case('video')
                    @php
                        $video = $layer['url'] ?? null;
                        $poster = $layer['poster'] ?? null;
                        $opacity = $numeric($layer['opacity'] ?? null, 0.5);
                        $blur = $numeric($layer['blur'] ?? null, 0);
                    @endphp

                    @if (filled($video))
                        <div class="lg-ambient__layer lg-ambient__art" style="--lg-art-opacity: {{ $opacity }}; --lg-art-blur: {{ $blur }}px;">
                            <video class="lg-ambient__video" autoplay muted loop playsinline @if (filled($poster)) poster="{{ $assetUrl($poster) }}" @endif>
                                <source src="{{ $assetUrl($video) }}" type="video/mp4" />
                            </video>
                        </div>
                    @endif
                    @break

                @case('html')
                    <div class="lg-ambient__layer lg-ambient__objects {{ is_string($layer['class'] ?? null) ? $layer['class'] : '' }}">
                        {!! $layer['html'] ?? '' !!}
                    </div>
                    @break

                @case('view')
                    @if (is_string($layer['view'] ?? null) && $layer['view'] !== '')
                        {!! view($layer['view'], is_array($layer['data'] ?? null) ? $layer['data'] : [])->render() !!}
                    @endif
                    @break
            @endswitch
        @endforeach
    </div>

    @if ($grainEnabled)
        <div class="lg-grain" aria-hidden="true" style="--lg-grain-opacity: {{ $grainOpacity }};" data-liquid-glass-grain></div>
    @endif
@endif
