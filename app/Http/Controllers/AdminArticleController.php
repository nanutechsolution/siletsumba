<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Category;
use App\Models\Prompt;
use App\Models\Tag;
use App\Rules\RequiredHtmlContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{

    public function index()
    {
        // Jika peran pengguna adalah 'admin', tampilkan semua berita
        if (Auth::user()->role === 'admin') {
            $articles = Article::with('category')->latest()->paginate(15);
        } else {
            // Jika peran adalah 'writer', tampilkan hanya berita yang ditulis oleh pengguna tersebut
            $articles = Article::with('category')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(15);
        }
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $prompts = Prompt::all();
        return view('admin.articles.create', compact('categories', 'tags', 'prompts'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => ['required', new RequiredHtmlContent()],
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'is_breaking' => 'nullable|boolean',
            'location_short' => 'required|string|max:255',
            'publish_option' => 'nullable|in:now,schedule',
            'scheduled_at' => 'nullable|date',

        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();
        $validated['scheduled_at'] = $request->scheduled_at ?? null;

        if ($request->input('publish_option') === 'now') {
            $validated['is_published'] = true;
            $validated['scheduled_at'] = now();
        } elseif ($request->input('publish_option') === 'schedule') {
            $validated['is_published'] = false;
            $validated['scheduled_at'] = $request->filled('scheduled_at')
                ? \Carbon\Carbon::parse($request->input('scheduled_at'))
                : null;
        } else {
            $validated['is_published'] = false;
            $validated['scheduled_at'] = null;
        }
        // Auto-generate excerpt
        $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 150);
        // Hapus key 'image' supaya tidak di-insert ke articles
        $imageFile = $validated['image'];
        unset($validated['image']);

        $article = Article::create($validated);
        $tags = collect($validated['tags'] ?? [])->map(function ($tag) {
            if (is_numeric($tag)) {
                // Tag lama
                return (int) $tag;
            } else {
                // Tag baru
                $slug = Str::slug($tag);
                $newTag = \App\Models\Tag::firstOrCreate(
                    ['slug' => $slug], // cek kalau sudah ada slug
                    ['name' => $tag]   // kalau belum ada, buat baru
                );
                return $newTag->id;
            }
        })->toArray();

        $article->tags()->sync($tags);
        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        // Pastikan penulis hanya bisa mengedit artikelnya sendiri
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        $article->load('images');
        $tags = Tag::all();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:article_images,id',
            'is_breaking' => 'nullable|boolean',
            'lokasi_short' => 'nullable|string|max:255',
            'location_short' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $article->update([
            'title' => $validated['title'],
            'is_published' => true,
            'content' => $validated['content'],
            'excerpt' => Str::limit(strip_tags($validated['content']), 150),
            'lokasi_short' => $validated['lokasi_short'] ?? null,
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['title']),
            'is_breaking' => $request->has('is_breaking') ? $validated['is_breaking'] : false,
            'user_id' => auth()->id(),
        ]);

        $article->tags()->sync($validated['tags'] ?? []);

        // Hapus gambar yang dicentang
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = $article->getMedia('images')->whereIn('id', $validated['delete_images']);
            foreach ($imagesToDelete as $media) {
                $media->delete();
            }
        }
        // Upload gambar baru
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $article->addMedia($image)
                    ->toMediaCollection('images');
            }
        }
        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }


    public function destroy(Article $article)
    {
        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil dihapus!');
    }
    public function generateContent(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|min:5',
        ]);
        $apiKey = env('GEMINI_API_KEY');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $apiKey,
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' =>  $request->prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Gagal request ke AI',
                'details' => $response->body()
            ], 500);
        }

        $result = $response->json();
        $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return response()->json([
            'content' => $aiText
        ]);
    }


    /**
     * Remove multiple resources from storage.
     */
    public function massDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'selected_articles' => 'required|array',
            'selected_articles.*' => 'string|exists:articles,slug',
        ]);

        $deletedCount = 0;
        DB::transaction(function () use ($request, &$deletedCount) {
            foreach ($request->input('selected_articles') as $slug) {
                $article = Article::where('slug', $slug)->first();
                if ($article) {
                    $article->delete();
                    $deletedCount++;
                }
            }
        });

        return redirect()->route('admin.articles.index')->with('success', "$deletedCount berita berhasil dihapus.");
    }
}
