<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View Composer untuk layout utama
        View::composer('*', function ($view) {
            $settings = Setting::all()->keyBy('key');
            $view->with('settings', $settings);
        });
    }
}
