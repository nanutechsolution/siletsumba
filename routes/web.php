<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminThemeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/tag/{slug}', [ArticleController::class, 'show'])->name('tags.show');
Route::get('/search', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/kategori/{slug}', [HomeController::class, 'getArticlesByCategorys'])
    ->name('articles.category');

Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/articles/category/{slug}', [App\Http\Controllers\HomeController::class, 'getArticlesByCategory']);

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::delete('articles/mass-delete', [AdminArticleController::class, 'massDestroy'])->name('articles.destroy.mass');
    Route::post('articles/{slug}/like', [ArticleController::class, 'like'])->name('articles.like');
    Route::get('/theme-settings', [AdminThemeController::class, 'index'])->name('theme.index');
    Route::put('/theme-settings', [AdminThemeController::class, 'update'])->name('theme.update');
    Route::post('articles/generate-content', [AdminArticleController::class, 'generateContent'])->name('articles.generate-content'); // Tambahkan baris ini
    Route::resource('prompts', PromptController::class);

    Route::resource('comments', AdminCommentController::class)->except(['show', 'create', 'store']);
    Route::post('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/berita/{slug}/like', [ArticleController::class, 'like'])->name('articles.like');
});

// Grup Rute Khusus untuk Penulis (penulis dan admin bisa mengakses)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Manajemen Artikel
    Route::resource('articles', AdminArticleController::class);
});

require __DIR__ . '/auth.php';
