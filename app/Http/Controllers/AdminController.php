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
        $totalArticles = Article::count();
        $totalViews = Article::sum('views');
        $pendingComments = Comment::where('status', 'pending')->count();
        $activeWriters = User::has('articles')->count();
        $recentArticles = Article::with('user', 'category')
            ->latest()
            ->select('title', 'slug', 'user_id', 'category_id', 'created_at', 'is_published')
            ->take(5)
            ->get();
        $recentComments = Comment::with('article')->latest()->where('status', 'pending')->take(5)->get();
        $trendingArticles = Article::with('category')->orderBy('views', 'desc')->take(5)->get();
        $totalComments = Comment::count();
        return view('admin.dashboard', compact(
            'totalArticles',
            'totalViews',
            'totalComments',
            'activeWriters',
            'recentArticles',
            'recentComments',
            'trendingArticles',
            'pendingComments',
            'recentComments'
        ));
    }
}
