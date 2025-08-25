<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }
        $articles = $query->latest()->take(5)->get();
        $hero = $articles->first();
        $latestArticles = Article::latest()->offset(1)->paginate(10);

        $trending = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();
        // breaking news
        $breakingNews = Article::where('is_breaking', true)
            ->latest()
            ->take(5)
            ->get();
        return view('home', compact('hero', 'latestArticles', 'trending', 'categories',  'breakingNews'));
    }
    public function getArticlesByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::with('category') // <-- eager load category
            ->where('category_id', $category->id)
            ->latest()
            ->take(6)
            ->get();

        return response()->json($articles);
    }

    public function getArticlesByCategorys($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();
        $articles = \App\Models\Article::where('category_id', $category->id)
            ->latest()
            ->paginate(6);

        $articlesCollection = $articles->getCollection();

        $hero = $articlesCollection->first();
        $latestArticles = Article::latest()->offset(1)->paginate(10);
        $trending = Article::orderBy('views', 'desc')->take(5)->get();
        $categories = Category::all();
        $breakingNews = Article::where('is_breaking', true)
            ->latest()
            ->take(5) // ambil max 5
            ->get();

        // Cek apakah slug karir
        if ($slug === 'karir') {
            // Tampilkan view khusus karir
            return view('karir.index', compact('categories'));
        } else {

            return view('home', compact('hero', 'latestArticles', 'trending', 'categories',  'breakingNews'));
        }
    }
}
