<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cek role
        $isAdmin = $user->hasRole('admin');

        // Base query
        $articleQuery = Article::query();
        $commentQuery = Comment::query();

        if (!$isAdmin) {
            // Kalau bukan admin, filter artikel miliknya sendiri
            $articleQuery->where('user_id', $user->id);

            // Filter komentar hanya untuk artikel miliknya
            $commentQuery->whereHas('article', fn($q) => $q->where('user_id', $user->id));
        }

        // Hitung statistik
        $totalArticles = $articleQuery->count();
        $totalViews = $articleQuery->sum('views');
        $recentArticles = $articleQuery->with('category')->latest()->take(5)->get();
        $trendingArticles = $articleQuery->with('category')->orderBy('views', 'desc')->take(5)->get();

        $totalComments = $commentQuery->count();
        $pendingComments = $commentQuery->where('status', 'pending')->count();
        $recentComments = $commentQuery->with('article')->latest()->where('status', 'pending')->take(5)->get();
        // Hanya admin yang lihat jumlah writer
        $activeWriters = $isAdmin ? User::has('articles')->count() : 0;
        return view('admin.dashboard', compact(
            'totalArticles',
            'totalViews',
            'totalComments',
            'activeWriters',
            'recentArticles',
            'recentComments',
            'trendingArticles',
            'pendingComments'
        ));
    }
}
