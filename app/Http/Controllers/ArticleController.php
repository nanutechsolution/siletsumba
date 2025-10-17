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
        $categories = Category::withCount(relations: 'articles')->get();
        $articles = Article::with(relations: ['category', 'user', 'images', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('welcome', compact('articles', 'tags', 'categories'));
    }

    public function show($slug, Request $request)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
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
            $q->where('status', 'published');
        })->get();
        // ambil artikel terkait (misal kategori sama)
        $related = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest()
            ->take(1)
            ->get();
        $popular = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        $latest = Article::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

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
            'DuckDuckBot',
            'Baiduspider',
            'YandexBot',
            'Sogou',
            'Exabot',
            'facebot',
            'ia_archiver'
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

        // Logging pencarian aman
        if ($query) {
            $searchLog = \App\Models\SearchLog::firstOrCreate(
                ['query' => $query],
                ['count' => 0, 'last_searched_at' => now()]
            );
            $searchLog->increment('count');
            $searchLog->update(['last_searched_at' => now()]);
        }

        $queryBuilder = Article::query()->with(['category', 'tags'])
            ->where('status', 'published');

        if ($query) {
            $queryBuilder->whereRaw(
                "MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE)",
                [$query]
            );
        }

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $queryBuilder->where('category_id', $category->id);
            }
        }

        // Sorting
        if ($sort === 'oldest')
            $queryBuilder->oldest();
        else
            $queryBuilder->latest();

        // Cache hasil search 1 menit
        $cacheKey = 'search:' . md5($query . $categorySlug . $sort . $request->get('page', 1));
        $articles = cache()->remember($cacheKey, 60, fn() => $queryBuilder->paginate(5)->withQueryString());

        // Trending articles bulan ini (cache 5 menit)
        $trendingArticles = cache()->remember(
            'trending_articles_month',
            300,
            fn() =>
            Article::where('status', 'published')
                ->whereMonth('created_at', now()->month)
                ->with('tags')
                ->orderBy('views', 'desc')
                ->take(5)
                ->get()
        );

        // Trending tags dari artikel bulan ini
        $trendingTags = $trendingArticles->pluck('tags')
            ->flatten()
            ->map(fn($tag) => $tag->name)
            ->countBy()
            ->sortDesc()
            ->take(5);

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
        $categories = Category::whereHas('articles')->get();

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


    public function nextPart($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Misal kita simpan posisi terakhir yang dibaca lewat query param
        $offset = request()->get('offset', 5);

        $paragraphs = explode('</p>', $article->full_content);
        $nextContent = array_slice($paragraphs, $offset, 5); // ambil 5 paragraf berikutnya

        return view('articles.show_next', [
            'article' => $article,
            'content' => $nextContent,
            'nextOffset' => $offset + 5,
        ]);
    }

}
