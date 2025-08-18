<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class AdminThemeController extends Controller
{
    public function index()
    {
        $theme = ThemeSetting::firstOrCreate(
            [],
            [
                'primary_color' => '#4299e1',
                'secondary_color' => '#f56565',
                'menu_background' => '#ffffff',
            ]
        );
        return view('admin.theme.index', compact('theme'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
            'secondary_color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
            'menu_background' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $theme = ThemeSetting::firstOrNew([]);
        $theme->update($validated);

        return back()->with('success', 'Pengaturan tema berhasil diperbarui!');
    }
}
