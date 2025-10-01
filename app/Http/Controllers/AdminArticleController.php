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
    public function preview($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Cek status, hanya boleh preview draft/scheduled
        if (!in_array($article->status, ['draft', 'scheduled'])) {
            abort(403, 'Artikel ini sudah dipublikasikan.');
        }

        // Cek role: penulis artikel, admin, atau editor
        if (
            auth()->id() !== $article->user_id &&
            !auth()->user()->hasRole(['admin', 'editor'])
        ) {
            abort(403, 'Anda tidak punya akses untuk preview artikel ini.');
        }
        $popular = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        $latest = Article::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();
        return view('articles.show', compact('article', 'popular', 'latest'));
    }
    public function index()
    {
        $user = auth()->user();
        $isAdminOrEditor = $user->hasRole(roles: ['admin', 'editor', 'super-admin']);
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
            'status' => 'required|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date',
        ]);
        // Tambahan data default
        $validated['user_id'] = auth()->id();
        $validated['is_breaking'] = $request->boolean('is_breaking', false);

        // Slug unik
        $slug = Str::slug($validated['title']);
        $count = Article::where('slug', 'like', "{$slug}%")->count();
        $validated['slug'] = $count ? "{$slug}-{$count}" : $slug;

        // Excerpt auto
        $validated['excerpt'] = Str::words(strip_tags($validated['content']), 25, '...');

        // Handle status & scheduled_at
        if ($validated['status'] === 'published') {
            // Langsung terbit
            $validated['scheduled_at'] = now();
        } elseif ($validated['status'] === 'scheduled') {
            if (!$request->filled('scheduled_at')) {
                return back()->withErrors(['scheduled_at' => 'Tanggal terbit wajib diisi untuk jadwal publikasi.']);
            }
            $validated['scheduled_at'] = \Carbon\Carbon::parse($request->input('scheduled_at'));
        } else {
            // Draft → biarkan null
            $validated['scheduled_at'] = null;
            $validated['status'] = 'draft';

        }

        // Simpan artikel
        $imageFile = $validated['image'];
        unset($validated['image']);
        $article = Article::create($validated);

        // Sinkronisasi tags
        $tags = collect($validated['tags'] ?? [])->map(function ($tag) {
            if (is_numeric($tag)) {
                return (int) $tag; // tag lama
            } else {
                $slug = Str::slug($tag);
                $newTag = \App\Models\Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tag]
                );
                return $newTag->id;
            }
        })->toArray();
        $article->tags()->sync($tags);

        // Upload image
        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')
                ->withResponsiveImages()
                ->toMediaCollection('images');
        }

        // Notifikasi jika writer
        if (auth()->user()->hasRole('writer')) {
            $adminPhone = config('services.fonnte.admin_phone');
            $msg = "📢 *Notifikasi Berita Baru*\n"
                . "───────────────────────\n"
                . "✍️ Penulis : *{$article->user->name}*\n"
                . "📰 Judul   : *{$article->title}*\n"
                . "📅 Tanggal : " . now()->format('d-m-Y H:i') . "\n"
                . "───────────────────────\n"
                . "⚠️ Status : *" . strtoupper($article->status) . "*\n\n"
                . "👉 Silakan cek & review di dashboard admin:\n"
                . url("/admin/articles/");

            FonnteService::send($adminPhone, $msg);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        $user = auth()->user();

        // Admin & Editor boleh edit semua
        if ($user->hasRole(['admin', 'editor', 'super-admin'])) {
            // lanjut
        } else {
            // Writer hanya bisa edit artikelnya sendiri & status masih draft
            if ($user->id !== $article->user_id || $article->status !== 'draft') {
                abort(403, 'Anda tidak punya akses untuk mengedit artikel ini.');
            }
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
            'content' => ['required', new RequiredHtmlContent()],
            'category_id' => 'required|exists:categories,id',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:media,id',
            'is_breaking' => 'nullable|boolean',
            'lokasi_short' => 'nullable|string|max:255',
            'location_short' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        // Handle status & scheduled_at
        if ($validated['status'] === 'published') {
            $validated['scheduled_at'] = now();
        } elseif ($validated['status'] === 'scheduled') {
            if (!$request->filled('scheduled_at')) {
                return back()->withErrors(['scheduled_at' => 'Tanggal terbit wajib diisi untuk jadwal publikasi.']);
            }
            $validated['scheduled_at'] = \Carbon\Carbon::parse($request->input('scheduled_at'));
        } else {
            $validated['scheduled_at'] = null;
            $validated['status'] = 'draft';
        }
        // Update artikel
        $data = [
            'title' => $validated['title'],
            'status' => $validated['status'],
            'scheduled_at' => $validated['scheduled_at'],
            'content' => $validated['content'],
            'excerpt' => Str::words(strip_tags($validated['content']), 25, '...'),
            'lokasi_short' => $validated['lokasi_short'] ?? null,
            'location_short' => $validated['location_short'] ?? null,
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['title']),
            'is_breaking' => $request->has('is_breaking') ? $validated['is_breaking'] : false,

        ];
        // Catat siapa yang publish
        if ($validated['status'] === 'published' && auth()->user()->hasRole(['admin', 'editor', 'super-admin'])) {
            $data['published_by'] = auth()->id();
        }
        $data['updated_by'] = auth()->id();
        $article->update($data);
        // Sinkronisasi tags
        $tags = collect($validated['tags'] ?? [])->map(function ($tag) {
            if (is_numeric($tag)) {
                return (int) $tag;
            } else {
                $slug = Str::slug($tag);
                $newTag = \App\Models\Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tag]
                );
                return $newTag->id;
            }
        })->toArray();
        $article->tags()->sync($tags);

        // Hapus gambar lama
        if (!empty($validated['delete_images'])) {
            foreach ($validated['delete_images'] as $id) {
                $media = $article->media()->find($id);
                if ($media) {
                    $media->delete();
                }
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
                                ['text' => $request->prompt]
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
        if (!$user->hasAnyRole(['admin', 'editor', 'super-admin'])) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus artikel.');
        }

        $deletedCount = 0;

        DB::transaction(function () use ($request, &$deletedCount) {
            foreach ($request->input('selected_articles') as $slug) {
                $article = Article::where('slug', $slug)->first();
                if (!$article)
                    continue;

                // Hapus media terkait
                $article->clearMediaCollection('images');

                $article->delete();
                $deletedCount++;
            }
        });
        return redirect()->route('admin.articles.index')->with('success', "$deletedCount berita berhasil dihapus.");
    }

    public function unpublish(Article $article)
    {
        $user = auth()->user();

        if (!$user->hasRole(['admin', 'editor'])) {
            abort(403, 'Anda tidak punya izin untuk unpublish artikel ini.');
        }

        $article->update([
            'status' => 'draft',
            'scheduled_at' => null,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dikembalikan ke draft.');
    }

}
