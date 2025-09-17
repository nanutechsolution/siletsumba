<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
            'show_in_footer' => 'required|boolean'
        ]);

        Page::create([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'status'  => $request->status,
            'show_in_footer' => $request->show_in_footer
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
            'show_in_footer' => 'required|boolean'
        ]);

        $page->update([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'status'  => $request->status,
            'show_in_footer'  => $request->show_in_footer,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus');
    }
}