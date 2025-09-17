<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Page;

class FooterServiceProvider extends ServiceProvider
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
        // Pastikan nama view sesuai dengan yang kamu include di layout.
        // Di sini kita menargetkan dua kemungkinan nama partial.
        View::composer(['*'], function ($view) {
            // Cache untuk performa (1 jam). Sesuaikan TTL kalau mau.
            $footerCategories = Cache::remember('footer_categories', 3600, function () {
                return Category::take(12)->get();
            });

            $footerPages = Cache::remember('footer_pages', 3600, function () {
                // pakai scope Page::footer() kalau sudah ada, atau fallback:
                if (method_exists(Page::class, 'scopeFooter')) {
                    return Page::footer()->get();
                }
                return Page::where('show_in_footer', true)
                    ->where('status', 'published')
                    ->get();
            });

            $view->with(compact('footerCategories', 'footerPages'));
        });
    }
}