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

    public function sendMessage(Request $request)
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
}