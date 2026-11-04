<?php

namespace Osama\FilamentLiquidGlass\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThemeCssController
{
    public function __invoke(): BinaryFileResponse
    {
        $path = dirname(__DIR__, 3).'/resources/css/liquid-glass.css';

        abort_unless(is_file($path), 404);

        return response()->file($path, [
            'Content-Type' => 'text/css; charset=UTF-8',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }
}
