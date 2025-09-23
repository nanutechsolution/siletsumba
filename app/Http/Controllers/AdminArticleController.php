<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Prompt;
use App\Models\Tag;
use App\Rules\RequiredHtmlContent;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdminOrEditor = $user->hasRole(['admin', 'editor']);
        // Jika peran pengguna adalah 'admin', tampilkan semua berita
        if ($isAdminOrEditor) {
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
            'tags' => 'required|array',
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
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor')) {
                $validated['is_published'] = true;
                $validated['scheduled_at'] = now();
            }
        } elseif ($request->input('publish_option') === 'schedule') {
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor')) {
                $validated['is_published'] = false;
                $validated['scheduled_at'] = $request->filled('scheduled_at')
                    ? \Carbon\Carbon::parse($request->input('scheduled_at'))
                    : null;
            } else {
                // Penulis tetap draft
                $validated['is_published'] = false;
                $validated['scheduled_at'] = null;
            }
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
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }
        if (auth()->user()->hasRole('user')) {
            $adminPhone = config('services.fonnte.admin_phone');
            $msg = "📢 *Notifikasi Berita Baru*\n"
                . "───────────────────────\n"
                . "✍️ Penulis : *{$article->user->name}*\n"
                . "📰 Judul   : *{$article->title}*\n"
                . "📅 Tanggal : " . now()->format('d-m-Y H:i') . "\n"
                . "───────────────────────\n"
                . "⚠️ Status : *Belum Dipublikasikan*\n\n"
                . "👉 Silakan cek & review di dashboard admin:\n"
                . url("/admin/articles/{$article->id}/edit");

            FonnteService::send($adminPhone, $msg);
        }
        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {

        $user = auth()->user();
        $isAdminOrEditor = $user->hasRole(['admin', 'editor']);
        if (!$isAdminOrEditor) {
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
            'delete_images.*' => 'exists:media,id',
            'is_breaking' => 'nullable|boolean',
            'lokasi_short' => 'nullable|string|max:255',
            'location_short' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $user = auth()->user();
        $isAdminOrEditor = $user->hasRole(['admin', 'editor']);
        if ($isAdminOrEditor) {
            $isPublished = $validated['is_published'];
        } else {
            $isPublished = false;
        }

        $article->update([
            'title' => $validated['title'],
            'is_published' => $isPublished,
            'content' => $validated['content'],
            'excerpt' => Str::limit(strip_tags($validated['content']), 150),
            'lokasi_short' => $validated['lokasi_short'] ?? null,
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['title']),
            'is_breaking' => $request->has('is_breaking') ? $validated['is_breaking'] : false,
            'user_id' => auth()->id(),
        ]);
        $article->tags()->sync($validated['tags'] ?? []);
        if (!empty($validated['delete_images'])) {
            foreach ($validated['delete_images'] as $id) {
                $media = $article->media()->find($id);
                if ($media) $media->delete();
            }
        }
        // Upload gambar baru
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $article->addMedia($image)
                    ->withResponsiveImages()
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }


    public function destroy(Article $article)
    {
        $user = auth()->user();

        // Hanya admin/editor boleh hapus semua artikel
        // Penulis hanya boleh hapus artikel sendiri
        if ($user->hasRole('writer') && $article->user_id !== $user->id) {
            return redirect()->route('admin.articles.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus artikel ini.');
        }
        $article->clearMediaCollection('images');

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

    public function massDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'selected_articles' => 'required|array',
            'selected_articles.*' => 'string|exists:articles,slug',
        ]);

        $user = auth()->user();

        // Cek role, hanya admin dan editor yang boleh
        if (!$user->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus artikel.');
        }

        $deletedCount = 0;

        DB::transaction(function () use ($request, &$deletedCount) {
            foreach ($request->input('selected_articles') as $slug) {
                $article = Article::where('slug', $slug)->first();
                if (!$article) continue;

                // Hapus media terkait
                $article->clearMediaCollection('images');

                $article->delete();
                $deletedCount++;
            }
        });
        return redirect()->route('admin.articles.index')->with('success', "$deletedCount berita berhasil dihapus.");
    }
}