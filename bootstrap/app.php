<?php

use App\Http\Middleware\AdminMiddleware;
use App\Models\Article;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 404 Not Found
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            try {
                $trending = Article::orderBy('views', 'desc')->take(6)->get();
            } catch (\Throwable $err) {
                $trending = collect();
            }

            return response()->view('errors.404', compact('trending'), 404);
        });
    })->create();