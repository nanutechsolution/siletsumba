<?php

namespace App\Providers;

use App\Models\ThemeSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $theme = ThemeSetting::firstOrCreate(
        //     [],
        //     [
        //         'primary_color' => '#4299e1',
        //         'secondary_color' => '#f56565',
        //         'menu_background' => '#ffffff',
        //     ]
        // );

        // View::share('theme', $theme);
    }
}
