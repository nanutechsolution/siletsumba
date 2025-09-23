<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Page;
use App\Models\SearchLog;

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
        View::composer(['*'], function ($view) {
            $footerCategories = Cache::remember('footer_categories', 3600, function () {
                return Category::whereHas('articles')
                    ->take(12)
                    ->get();
            });
            if (method_exists(Page::class, 'scopeFooter')) {
                $footerPages = Page::footer()->get();
            } else {
                $footerPages = Page::where('show_in_footer', true)
                    ->where('status', 'published')
                    ->get();
            }
            // Popular searches 30 hari terakhir (cache 5 menit)
            $popularSearches = cache()->remember(
                'popular_searches_30d',
                300,
                fn() =>
                SearchLog::where('last_searched_at', '>=', now()->subDays(30))
                    ->orderBy('count', 'desc')
                    ->take(5)
                    ->get()
            );
            $view->with(compact('footerCategories', 'footerPages', 'popularSearches'));
        });
    }
}