<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('dashboard');

    Route::get('/konten', function () {
        return Inertia::render('admin/Konten');
    })->name('konten');

    Route::get('/artikel', function () {
        return Inertia::render('admin/Artikel');
    })->name('artikel');
    
    Route::get('/layanan', function () {
        return Inertia::render('admin/Layanan');
    })->name('layanan');

    Route::get('/minat-bakat', function () {
        return Inertia::render('admin/MinatBakat');
    })->name('minat-bakat');
    
    Route::get('/gaya-belajar', function () {
        return Inertia::render('admin/GayaBelajar');
    })->name('gaya-belajar');

    Route::get('/intelegensi', function () {
        return Inertia::render('admin/Intelegensi');
    })->name('intelegensi');

});

require __DIR__.'/settings.php';
