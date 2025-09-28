<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Mengambil artikel hero (artikel terbaru pertama)
        $hero = Article::with(['category'])
            ->where('status', 'published')
            ->latest()
            ->first();
        // 2. Mengambil artikel terbaru (kecuali artikel hero)
        $latestArticles = Article::with(relations: ['category'])
            ->where('status', 'published')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('id', '!=', $hero->id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        // 2.a Mengambil 5 artikel terbaru untuk sidebar (kecuali hero)
        $latestFive = Article::with(['category'])
            ->where('status', operator: 'published')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('id', '!=', $hero->id);
            })
            ->latest()
            ->take(5)
            ->get();
        // 3. Mengambil artikel terpopuler berdasarkan views
        $trending = Article::with(['category'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // 4. Mengambil semua kategori yang memiliki artikel terpublikasi
        $categories = Category::whereHas('articles', function ($q) {
            $q->where('status', 'published');
        })
            ->withCount([
                'articles' => function ($q) {
                    $q->where('status', 'published');
                }
            ])
            ->get();

        // 5. Mengambil 5 berita breaking news terbaru
        $breakingNews = Article::with(['category'])
            ->where('status', 'published')
            ->where('is_breaking', true)
            ->latest()
            ->take(5)
            ->get();


        return view('home', compact('hero', 'latestArticles', 'latestFive', 'trending', 'categories', 'breakingNews'));
    }
    public function getArticlesByCategory(string $slug): View
    {
        // 1. Temukan kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Cek apakah slug adalah 'karir' untuk view khusus
        if ($slug === 'karir') {
            $categories = Category::all();
            return view('karir.index', compact('categories'));
        }

        // 2. Mengambil artikel hero dari kategori yang dipilih
        $hero = Article::with(['category'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->first();

        // 3. Mengambil artikel terbaru (kecuali hero) dari kategori yang dipilih
        $latestArticles = Article::with(['category'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->when($hero, function ($query) use ($hero) {
                return $query->where('id', '!=', $hero->id);
            })
            ->latest()
            ->paginate(1)
            ->withQueryString();
        // 3.a Mengambil 5 artikel terbaru untuk sidebar (kecuali hero)
        $latestFive = Article::with(['category'])
            ->where('status', operator: 'published')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('id', '!=', $hero->id);
            })
            ->latest()
            ->take(5)
            ->get();
        // 4. Mengambil 5 berita terpopuler
        $trending = Article::with(['category'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // 5. Mengambil 5 berita breaking news
        $breakingNews = Article::with(['category'])
            ->where('status', 'published')
            ->where('is_breaking', true)
            ->latest()
            ->take(5)
            ->get();

        // 6. Mengambil semua kategori untuk navigasi/sidebar
        $categories = Category::whereHas('articles', function ($query) {
            $query->where('status', 'published');
        })->get();
        return view('home', compact('hero', 'latestArticles', 'trending', 'categories', 'breakingNews', 'latestFive', 'category'));
    }

    public function getByTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        // 1. Hero article (artikel terbaru dari tag)
        $hero = $tag->articles()
            ->with(['category'])
            ->where('status', 'published')
            ->latest()
            ->first();

        // 2. Artikel terbaru kecuali hero
        $latestArticles = $tag->articles()
            ->with(['category', 'user', 'tags'])
            ->where('status', 'published')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('articles.id', '!=', $hero->id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        // 2.a Mengambil 5 artikel terbaru untuk sidebar (kecuali hero)
        $latestFive = $tag->articles()
            ->with(['category', 'user', 'tags'])
            ->where('status', 'published')
            ->when($hero, function ($query) use ($hero) {
                return $query->where('articles.id', '!=', $hero->id);
            })
            ->latest()
            ->take(5)
            ->get();
        // 3. Artikel terpopuler (trending)
        $trending = $tag->articles()
            ->with(['category', 'user', 'tags'])
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // 4. Semua kategori dengan artikel terpublikasi
        $categories = Category::whereHas('articles', function ($q) {
            $q->where('status', 'published');
        })
            ->withCount([
                'articles' => function ($q) {
                    $q->where('status', 'published');
                }
            ])
            ->get();

        // 5. 5 berita breaking news terbaru
        $breakingNews = $tag->articles()
            ->with(['category', 'user', 'tags'])
            ->where('status', 'published')
            ->where('is_breaking', true)
            ->latest()
            ->take(5)
            ->get();
        return view('home', compact('hero', 'latestArticles', 'latestFive', 'trending', 'categories', 'breakingNews', 'tag'));
    }
}
