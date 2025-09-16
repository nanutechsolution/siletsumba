<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\RateLimiter;

class CommentController extends Controller
{
    protected $spamKeywords = [
        'website redesign',
        'SEO',
        'klik link',
        'gratis',
        'promo',
        'visit',
        'buy now'
    ];

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'body'       => 'required|string',
        ]);

        // Rate limit: max 3 komentar per 1 menit per IP
        $key = 'comment:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Terlalu banyak komentar, silakan coba lagi nanti.');
        }
        RateLimiter::hit($key, 60); // expire 60 detik

        $status = 'pending'; // default

        // Cek spam kata kunci
        foreach ($this->spamKeywords as $keyword) {
            if (stripos($validated['body'], $keyword) !== false) {
                $status = 'spam';
                break;
            }
        }

        // Cek link di komentar
        if (preg_match('/https?:\/\/[^\s]+/', $validated['body'])) {
            $status = 'spam';
        }

        // Simpan komentar
        Comment::create([
            'article_id' => $validated['article_id'],
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'body'       => $validated['body'],
            'status'     => $status,
        ]);

        if ($status === 'spam') {
            return back()->with('error', 'Komentar Anda terdeteksi sebagai spam dan tidak akan muncul.');
        }

        return back()->with('success', 'Komentar Anda berhasil dikirim dan menunggu moderasi.');
    }
}