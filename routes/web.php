<?php

use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PromptController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminThemeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/tag/{slug}', [ArticleController::class, 'show'])->name('tags.show');
Route::get('/search', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/kategori/{slug}', [HomeController::class, 'getArticlesByCategory'])
    ->name('articles.category');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/tags/{slug}', [HomeController::class, 'getByTag'])->name('tags.show');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/sitemap.xml', function () {
    return Cache::remember('sitemap', now()->addHours(6), function () {
        $sitemap = Sitemap::create();
        // Homepage
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency('daily'));

        // Artikel (ambil dari database)
        Article::where('is_published', true)->get()->each(function ($article) use ($sitemap) {
            $sitemap->add(
                Url::create("/articles/{$article->slug}")
                    ->setLastModificationDate($article->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency('daily')
            );
        });
        // Halaman statis (opsional)
        Page::all()->each(function ($page) use ($sitemap) {
            $sitemap->add(
                Url::create("/page/{$page->slug}")
                    ->setLastModificationDate($page->updated_at)
                    ->setPriority(0.6)
                    ->setChangeFrequency('monthly')
            );
        });

        return $sitemap->toResponse(request());
    });
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', function () {
        return view('admin.users.index');
    })->name('users.index');
    Route::get('/users/create', function () {
        return view('admin.users.create');
    })->name('users.create');
    Route::get('/users/{user}/edit', function (User $user) {
        return view('admin.users.edit', compact('user'));
    })->name('users.edit');
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
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('tags', TagController::class);
    Route::resource('ads', AdController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('articles', AdminArticleController::class);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/berita/{slug}/like', [ArticleController::class, 'like'])->name('articles.like');
});

require __DIR__ . '/auth.php';