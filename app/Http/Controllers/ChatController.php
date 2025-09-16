<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Article;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function sendMessages(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);
        $userMessage = $request->message;
        // Prompt ke Gemini
        $apiKey = env('GEMINI_API_KEY');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $apiKey,
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' =>  $userMessage]
                    ]
                ]
            ]
        ]);
        if ($response->failed()) {
            return response()->json([
                'reply' => 'Gagal request ke AI',
            ], 500);
        }

        $result = $response->json();
        $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'AI tidak menghasilkan jawaban';


        return response()->json([
            'reply' => $aiText
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'article_id' => 'nullable|integer',
        ]);
        $userMessage = $request->message;
        // Ambil konteks artikel jika ada
        $articleContext = '';
        if ($request->article_id) {
            $article = \App\Models\Article::with('category', 'tags')->find($request->article_id);
            if ($article) {
                $tags = $article->tags->pluck('name')->join(', ');
                $articleContext = "Artikel sedang dibaca: '{$article->title}'.
Kategori: '{$article->category->name}'.
Tags: '{$tags}'.
Ringkasan: '{$article->excerpt}'.";
            }
        }
        // Prompt ke Gemini API
        $apiKey = env('GEMINI_API_KEY');
        $prompt = "Anda adalah editor senior Silet Sumba. Jawab pertanyaan user dengan lugas, profesional, dan faktual. {$articleContext}\nPertanyaan user: {$userMessage}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $apiKey,
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            return response()->json([
                'reply' => '⚠️ Gagal request ke AI',
            ], 500);
        }

        $result = $response->json();
        $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'AI tidak menghasilkan jawaban';

        return response()->json([
            'reply' => $aiText
        ]);
    }
}