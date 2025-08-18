<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 6 berita terbaru, diurutkan dari yang terbaru
        $latestArticles = Article::latest()->take(6)->get();

        // Ambil semua kategori
        $categories = Category::all();

        return view('home', compact('latestArticles', 'categories'));
    }
}
