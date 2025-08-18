<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
            ->latest()
            ->paginate(10); // Mengambil 10 artikel per halaman

        return view('welcome', compact('articles'));
    }


    public function show(string $slug)
    {
        $article = Article::with('category', 'comments')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('article.show', compact('article'));
    }
}
