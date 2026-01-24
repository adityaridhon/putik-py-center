<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Models\Service;
use App\Models\CompanyProfile;
use App\Models\Client;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
   $profile = CompanyProfile::first();

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'companyProfile' => $profile // <-- Kirim data ini ke Vue
    ]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('dashboard');

    Route::get('/konten', function () {
        $profile = CompanyProfile::first();
        $services = Service::all();
        $clients = Client::all();
        
        return Inertia::render('admin/Konten', [
            'profile' => $profile,
            'services' => $services,
            'clients' => $clients,
        ]);
    })->name('konten');

    Route::get('/artikel', function () {
        return Inertia::render('admin/Artikel');
    })->name('artikel');
    
    Route::get('/layanan', function () {
        $services = Service::where('is_active', true)->get();
        return Inertia::render('admin/Layanan', [
            'listServices' => $services 
        ]);
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

    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/profil-umum', [CompanyProfileController::class, 'index'])
        ->name('admin.general-profile.index');
    
    Route::post('/profil-umum', [CompanyProfileController::class, 'update'])
        ->name('admin.general-profile.update');

    // Routes untuk Services (Layanan)
    Route::resource('services', ServiceController::class)->except(['create', 'edit']);
    
    // Routes untuk Clients (Klien)
    Route::resource('clients', ClientController::class)->except(['create', 'edit']);
});

require __DIR__.'/settings.php';
