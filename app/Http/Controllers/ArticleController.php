<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\SearchLog;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::withCount('articles')->get();
        $articles = Article::with(['category', 'user', 'images', 'tags'])
            ->where('is_published', 1)
            ->latest()
            ->paginate(10);

        return view('welcome', compact('articles', 'tags', 'categories'));
    }

    public function show($slug, Request $request)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', 1)
            ->with(['category', 'tags'])
            ->firstOrFail();
        $ip = $request->ip();
        $expiresAt = now()->addHours(24);
        $cacheKey = 'article_view_' . $article->id . '_' . $ip;
        // update jumlah views
        if (!Cache::has($cacheKey)) {
            if (!$this->isBot(request()->header('User-Agent'))) {
                $article->increment('views');
            }
            Cache::put($cacheKey, true, $expiresAt);
        }
        $categories = Category::whereHas('articles', function ($q) {
            $q->where('is_published', 1);
        })->get();
        // ambil artikel terkait (misal kategori sama)
        $related = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(5)
            ->get();
        $popular = Article::orderBy('views', 'desc')->take(5)->get();
        $latest = Article::latest()->take(5)->get();
        return view('articles.show', compact('article', 'related', 'latest', 'popular', 'categories'));
    }

    /**
     * Cek apakah User-Agent adalah bot.
     */
    private function isBot($userAgent): bool
    {
        $bots = [
            'Googlebot',
            'Bingbot',
            'Slurp',
            'Baiduspider',
            'YandexBot',
            'DuckDuckBot',
        ];

        foreach ($bots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }
    public function search(Request $request)
    {
        $start = microtime(true);
        $query = $request->input('q');
        $categorySlug = $request->input('category');
        $sort = $request->input('sort');
        if ($query) {
            // Simpan log pencarian
            \App\Models\SearchLog::updateOrCreate(
                ['query' => $query],
                ['count' => DB::raw('count + 1')]
            );
        }
        $queryBuilder = Article::query()->with(['category', 'tags']);

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            });
        }
        // Ambil semua kategori untuk filter dropdown
        $categories = Category::all();
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $queryBuilder->where('category_id', $category->id);
            }
        }

        // Sorting
        if ($sort == 'latest') $queryBuilder->latest();
        elseif ($sort == 'oldest') $queryBuilder->oldest();
        else $queryBuilder->latest(); // default

        $articles = $queryBuilder->paginate(5)->withQueryString();

        // Trending tags
        $trendingArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $trendingTags = $trendingArticles->pluck('tags')
            ->flatten()
            ->map(fn($tag) => $tag->name)
            ->countBy()
            ->sortDesc()
            ->take(5);

        // Popular searches
        $popularSearches = SearchLog::orderBy('count', 'desc')->take(5)->get();

        $end = microtime(true);
        $searchTime = number_format($end - $start, 2);

        return view('articles.search', compact(
            'articles',
            'query',
            'trendingTags',
            'popularSearches',
            'searchTime',
            'trendingArticles',
            'categories'
        ));
    }

    public function like(string $slug): RedirectResponse
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Logika untuk mencatat like
        $article->increment('likes');

        return back()->with('success', 'Artikel berhasil disukai!');
    }
}