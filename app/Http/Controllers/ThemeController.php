<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Persists the user's theme choice to a cookie so the server-side
 * <html data-theme> attribute is correct on the next request.
 */
class ThemeController extends Controller
{
    public function update(Request $request): Response
    {
        $data = $request->validate([
            'theme' => 'required|in:light,dark',
        ]);
        $minutes = 60 * 24 * 365;
        return response('', 204)->cookie('ge-theme', $data['theme'], $minutes, '/', null, false, false, false, 'lax');
    }
}
