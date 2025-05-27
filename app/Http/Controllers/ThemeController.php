<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Available themes in DaisyUI 5.
     *
     * @var array<string>
     */
    protected array $availableThemes = [
        'light', 'dark', 'cupcake', 'bumblebee', 'emerald', 'corporate',
        'synthwave', 'retro', 'cyberpunk', 'valentine', 'halloween',
        'garden', 'forest', 'aqua', 'lofi', 'pastel', 'fantasy',
        'wireframe', 'black', 'luxury', 'dracula', 'cmyk', 'autumn',
        'business', 'acid', 'lemonade', 'night', 'coffee', 'winter',
        'dim', 'nord', 'sunset',
    ];

    /**
     * Update the user's theme preference in the session.
     */
    public function update(Request $request): JsonResponse
    {
        $theme = $request->input('theme', 'light');

        // Validate that the theme is available in DaisyUI 5
        if (! in_array($theme, $this->availableThemes)) {
            $theme = 'light';
        }

        // Store theme in session for SSR rendering
        session(['theme' => $theme]);

        return response()->json(['success' => true, 'theme' => $theme]);
    }
}
