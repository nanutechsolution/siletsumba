<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Text/textarea fields
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // File fields
        if ($request->hasFile('site_logo_url')) {
            $setting = Setting::firstOrCreate(['key' => 'site_logo_url']);
            $setting->clearMediaCollection('site_logo_url');
            $setting->addMediaFromRequest('site_logo_url')->toMediaCollection('site_logo_url');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
