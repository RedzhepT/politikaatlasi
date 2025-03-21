<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ImageUploadController;

// Ana sayfa
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/home', '/', 301);

// Makale route'ları
Route::prefix('ulke-yonetim-sistemleri')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/ara', [ArticleController::class, 'search'])->name('articles.search');
    Route::get('/kategori/{category:slug}', [ArticleController::class, 'category'])->name('articles.category');
    Route::get('/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
});

// Statik sayfalar
Route::get('/hakkimizda', [PageController::class, 'about'])->name('about');
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');

// İletişim formu
Route::post('/iletisim', [PageController::class, 'sendMessage'])->name('contact.send');

// Auth Routes - sadece giriş yapmamış kullanıcılar erişebilir
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

// Çıkış yapma route'u - sadece giriş yapmış kullanıcılar
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('upload/image', [ImageUploadController::class, 'upload'])->name('upload.image');
});

Auth::routes();

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
});
