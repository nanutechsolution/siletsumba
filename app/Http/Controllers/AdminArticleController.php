<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Category;
use App\Models\Tag;
use Gemini;
use Gemini\Enums\ModelVariation;
use Gemini\GeminiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{


    public function index()
    {
        $categories = Category::all();
        $articles = Article::with('category', 'tags')
            ->latest()
            ->paginate(10);

        return view('welcome', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all(); // <- ini wajib dikirim
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tambahkan .* untuk validasi array
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $article = Article::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:article_images,id',
        ]);

        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
        ]);

        // Hapus gambar yang dicentang
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = ArticleImage::whereIn('id', $validated['delete_images'])->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->path); // hapus file fisik
                $img->delete(); // hapus record
            }
        }

        // Tambahkan gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create(['path' => $path]);
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
                        ['text' =>  "Bertindak sebagai jurnalis senior di sebuah kantor berita. Buatlah sebuah artikel berita lengkap tentang topik berikut: '" . $request->prompt . "'. Pastikan artikel itu memiliki judul yang menarik, dan setidaknya 3 paragraf. Gunakan bahasa yang lugas, informatif, dan akurat seperti gaya penulisan berita. Berikan judul sebagai baris pertama, diikuti oleh isi artikel."]
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
}
