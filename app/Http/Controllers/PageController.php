<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        $categories = Category::whereHas('articles', function ($q) {
            $q->where('is_published', true);
        })
            ->withCount(['articles' => function ($q) {
                $q->where('is_published', true);
            }])
            ->get();
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.pages.show', compact('page', 'categories'));
    }
}