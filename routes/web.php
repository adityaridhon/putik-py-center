<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Models\CompanyProfile;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ArticleController;

Route::get('/', function () {
   $profile = CompanyProfile::first();

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'companyProfile' => $profile 
    ]);
    })->name('home');

    Route::get('/tentang-kami', function () {
        return Inertia::render('user/tentang-kami/Index');
    })->name('tentang-kami');

    Route::get('/layanan-kami', function () {
        return Inertia::render('user/layanan-kami/Index');
    })->name('layanan-kami');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', fn() => Inertia::render('admin/dashboard/Index'))->name('dashboard');

    // Company Profile & Content Management
    Route::get('/admin/konten', [CompanyProfileController::class, 'index'])->name('konten');
    Route::get('/admin/konten/edit', [CompanyProfileController::class, 'edit'])->name('konten.edit');
    Route::post('/admin/konten', [CompanyProfileController::class, 'update'])->name('konten.update');
    
    // Services Management
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('service');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('service.store');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('service.destroy');
    
    // Clients Management
    Route::resource('admin/clients', ClientController::class)->except(['create', 'edit']);

    // Articles Management
    Route::get('/admin/articles', [ArticleController::class, 'index'])->name('article');
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/admin/articles', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/admin/articles/{article:slug}', [ArticleController::class, 'show'])->name('article.show');
    Route::get('/admin/articles/{article:slug}/edit', [ArticleController::class, 'edit'])->name('article.edit');
    Route::put('/admin/articles/{article:slug}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/admin/articles/{article:slug}', [ArticleController::class, 'destroy'])->name('article.destroy');

    // Bookings
    Route::post('/admin/booking', [BookingController::class, 'store'])->name('booking.store');

    // Assessment Modules
    Route::get('/admin/asesmen/minat-bakat', fn() => Inertia::render('admin/tes-minat-bakat/Index'))->name('minatBakat');
    Route::get('/admin/asesmen/gaya-belajar', fn() => Inertia::render('admin/tes-gaya-belajar/Index'))->name('gayaBelajar');
    Route::get('/admin/asesmen/intelegensi', fn() => Inertia::render('admin/tes-intelegensi/Index'))->name('intelegensi');
}); 
require __DIR__.'/settings.php';
