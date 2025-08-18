<?php
// File: app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login dan user_id-nya adalah 1 (contoh admin)
        if (Auth::check() && Auth::user()->id === 1) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke halaman utama
        return redirect('/');
    }
}
