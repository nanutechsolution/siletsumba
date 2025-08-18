<?php

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
Route::get('articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('articles', AdminArticleController::class); // Tambahkan baris ini
    Route::get('/theme-settings', [AdminThemeController::class, 'index'])->name('theme.index');
    Route::put('/theme-settings', [AdminThemeController::class, 'update'])->name('theme.update');
    Route::post('articles/generate-content', [AdminArticleController::class, 'generateContent'])->name('articles.generate-content'); // Tambahkan baris ini

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
