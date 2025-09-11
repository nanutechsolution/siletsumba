<?php

namespace App\Providers;

use App\Models\Comment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Gunakan View Composer untuk mengirim data ke semua view yang menggunakan layout `navigation`
        View::composer('layouts.navigation', function ($view) {
            $pendingComments = Comment::where('status', 'pending')->count();
            $view->with('pendingComments', $pendingComments);
        });
    }
}
