<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Models\CompanyProfile;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\InterestCategoryController;
use App\Http\Controllers\Admin\InterestJobController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\LearningStyleController;
use App\Http\Controllers\Admin\TestTokenController;


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
    
    Route::get('/kontak', function () {
        return Inertia::render('user/kontak/Index');
    })->name('kontak');

    Route::get('/tes-online', function () {
        return Inertia::render('user/daftar-layanan/Index');
    })->name('daftar-layanan');

    Route::get('/tes-online/minat-bakat', function () {
        return Inertia::render('user/minat-bakat/Index');
    })->name('tes-online.minat-bakat');

    Route::get('/tes-online/minat-bakat/tes', function () {
        return Inertia::render('user/minat-bakat/Tes');
    })->name('tes-online.minat-bakat.tes');

    Route::get('/tes-online/minat-bakat/selesai', function () {
        return Inertia::render('user/minat-bakat/Selesai');
    })->name('tes-online.minat-bakat.selesai');

    Route::get('/tes-online/inteligensi', function () {
        return Inertia::render('user/inteligensi/Index');
    })->name('tes-online.inteligensi');

    Route::get('/tes-online/inteligensi/tes', function () {
        return Inertia::render('user/inteligensi/Tes');
    })->name('tes-online.inteligensi.tes');

    Route::get('/tes-online/inteligensi/selesai', function () {
        return Inertia::render('user/inteligensi/Selesai');
    })->name('tes-online.inteligensi.selesai');

    Route::get('/tes-online/gaya-belajar', function () {
        return Inertia::render('user/gaya-belajar/Index');
    })->name('tes-online.gaya-belajar');

    Route::get('/tes-online/gaya-belajar/tes', function () {
        return Inertia::render('user/gaya-belajar/Tes');
    })->name('tes-online.gaya-belajar.tes');

    Route::get('/tes-online/gaya-belajar/selesai', function () {
        return Inertia::render('user/gaya-belajar/Selesai');
    })->name('tes-online.gaya-belajar.selesai');

    Route::get('/booking-layanan', function () {
        return Inertia::render('user/booking-layanan/Index');
    })->name('booking-layanan');

    Route::get('/artikel', function () {
        return Inertia::render('user/artikel/Index');
    })->name('artikel');

    Route::get('/artikel/{slug}', function (string $slug) {
        return Inertia::render('user/artikel/detail', [
            'slug' => $slug,
        ]);
    })->name('artikel.detail');

Route::middleware(['auth'])->group(function () {
    // Dashboard user
    Route::get('/user/dashboard', fn() => Inertia::render('user/dashboard/Index'))->name('userDashboard');

});

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard admin
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

    // Minat Bakat
    Route::get('/admin/asesmen/minat-bakat', [InterestCategoryController::class, 'index'])->name('minatBakat');
    Route::get('/admin/asesmen/minat-bakat/{id}/edit', [InterestCategoryController::class, 'edit'])->name('minatBakat.edit');
    Route::put('/admin/asesmen/minat-bakat/{id}', [InterestCategoryController::class, 'update'])->name('minatBakat.update');

    // Minat Bakat Jobs
    Route::post('/admin/asesmen/minat-bakat/jobs', [InterestJobController::class, 'store'])->name('minatBakat.jobs.store');
    Route::put('/admin/asesmen/minat-bakat/jobs/{id}', [InterestJobController::class, 'update'])->name('minatBakat.jobs.update');
    Route::delete('/admin/asesmen/minat-bakat/jobs/{id}', [InterestJobController::class, 'destroy'])->name('minatBakat.jobs.destroy');


    // Gaya Belajar
    Route::get('/admin/asesmen/gaya-belajar', [LearningStyleController::class, 'index'])->name('gayaBelajar');
    Route::get('/admin/asesmen/gaya-belajar/create', [LearningStyleController::class, 'create'])->name('gayaBelajar.create');
    Route::post('/admin/asesmen/gaya-belajar', [LearningStyleController::class, 'store'])->name('gayaBelajar.store');
    Route::put('/admin/asesmen/gaya-belajar/{id}', [LearningStyleController::class, 'update'])->name('gayaBelajar.update');
    Route::delete('/admin/asesmen/gaya-belajar/{id}', [LearningStyleController::class, 'destroy'])->name('gayaBelajar.destroy');


    // Intelegensi
    Route::get('/admin/asesmen/intelegensi', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'index'])->name('intelegensi');
    Route::get('/admin/asesmen/intelegensi/{id}/edit', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'edit'])->name('intelegensi.edit');
    Route::put('/admin/asesmen/intelegensi/{id}', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'update'])->name('intelegensi.update');
    Route::delete('/admin/asesmen/intelegensi/{id}', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'destroy'])->name('intelegensi.destroy');
    Route::post('/admin/asesmen/intelegensi/questions', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'storeQuestion'])->name('intelegensi.questions.store');
    Route::post('/admin/asesmen/intelegensi/questions/bulk', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'bulkStoreQuestions'])->name('intelegensi.questions.bulk-store');
    Route::put('/admin/asesmen/intelegensi/questions/{id}', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'updateQuestion'])->name('intelegensi.questions.update');
    Route::delete('/admin/asesmen/intelegensi/questions/{id}', [App\Http\Controllers\Admin\IntelligenceTestController::class, 'destroyQuestion'])->name('intelegensi.questions.destroy');


    // Bank Soal
    Route::get('/admin/asesmen/bank-soal', [TestTokenController::class, 'index'])->name('bankSoal');
    Route::get('/admin/asesmen/bank-soal/create', [TestTokenController::class, 'create'])->name('bankSoal.create');
    Route::post('/admin/asesmen/bank-soal', [TestTokenController::class, 'store'])->name('bankSoal.store');
    Route::get('/admin/asesmen/bank-soal/{batch}', [TestTokenController::class, 'show'])->name('bankSoal.show');
    Route::get('/admin/asesmen/bank-soal/{batch}/edit', [TestTokenController::class, 'edit'])->name('bankSoal.edit');
    Route::put('/admin/asesmen/bank-soal/{batch}', [TestTokenController::class, 'update'])->name('bankSoal.update');
    Route::delete('/admin/asesmen/bank-soal/{batch}', [TestTokenController::class, 'destroy'])->name('bankSoal.destroy');

    // Laporan Psikologi
    Route::get('/admin/laporan-psikologi', [App\Http\Controllers\Admin\PsychologicalReportController::class, 'index'])->name('laporanPsikologi');
    Route::get('/admin/laporan-psikologi/{id}', [App\Http\Controllers\Admin\PsychologicalReportController::class, 'show'])->name('laporanPsikologi.detail');
    Route::post('/admin/laporan-psikologi/{id}/upload', [App\Http\Controllers\Admin\PsychologicalReportController::class, 'uploadReport'])->name('laporanPsikologi.upload');
    Route::get('/admin/laporan-psikologi/{id}/download', [App\Http\Controllers\Admin\PsychologicalReportController::class, 'downloadReport'])->name('laporanPsikologi.download');
    Route::delete('/admin/laporan-psikologi/{id}', [App\Http\Controllers\Admin\PsychologicalReportController::class, 'destroy'])->name('laporanPsikologi.destroy');


    // Manajemen Pengguna
    Route::get('/admin/kelola-pengguna', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('kelolaPengguna');
    Route::get('/admin/kelola-pengguna/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('kelolaPengguna.detail');
    Route::delete('/admin/kelola-pengguna/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('kelolaPengguna.destroy');

}); 
require __DIR__.'/settings.php';
