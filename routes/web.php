<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Models\CompanyProfile;
use App\Models\Article;
use App\Models\Client;
use App\Models\Service;
use App\Models\Psychologist;
use App\Models\InterestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PsychologistController;
use App\Http\Controllers\Admin\InterestCategoryController;
use App\Http\Controllers\Admin\InterestJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\LearningStyleController;
use App\Http\Controllers\Admin\TestTokenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\IntelligenceTestCategory;
use App\Models\LearningStyleStatement;
use App\Http\Controllers\UserProfileController;


Route::get('/', function () {
   $profile = CompanyProfile::first();
   $partnerLogos = Client::query()
        ->whereNotNull('logo')
        ->latest()
        ->get()
        ->map(function (Client $client) {
            return $client->logo_url;
        })
        ->values();

   $articles = Article::query()
        ->with('category:id,name')
        ->where('status', 'published')
        ->latest('published_at')
        ->latest('created_at')
        ->limit(6)
        ->get()
        ->map(function (Article $article) {
            return [
                'judul' => $article->title,
                'deskripsi' => $article->description,
                'gambar' => $article->cover_image_url ?? '/images/Artikel_1.jpg',
                'kategori' => $article->category?->name ?? 'Umum',
                'tanggal' => $article->published_at?->translatedFormat('d F Y')
                    ?? $article->created_at->translatedFormat('d F Y'),
                'slug' => $article->slug,
            ];
        });

    $services = Service::query()
        ->where('is_active', true)
        ->latest('created_at')
        ->get()
        ->map(function (Service $service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
            ];
        });

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'companyProfile' => $profile,
        'partnerLogos' => $partnerLogos,
        'articles' => $articles,
        'services' => $services,
    ]);
    })->name('home');

    Route::get('/tentang-kami', function () {
        $psychologists = Psychologist::query()
            ->latest('created_at')
            ->get()
            ->map(function (Psychologist $psychologist) {
                return [
                    'id' => $psychologist->id,
                    'name' => $psychologist->name,
                    'specialization' => $psychologist->specialization,
                    'photo_url' => $psychologist->photo_url,
                ];
            });

        return Inertia::render('user/tentang-kami/Index', [
            'psychologists' => $psychologists,
        ]);
    })->name('tentang-kami');

    Route::get('/layanan-kami', function () {
        $services = Service::query()
            ->where('is_active', true)
            ->latest('created_at')
            ->get()
            ->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'image_url' => $service->image_url,
                ];
            });

        return Inertia::render('user/layanan-kami/Index', [
            'services' => $services,
        ]);
    })->name('layanan-kami');
    
    Route::get('/kontak', function () {
        return Inertia::render('user/kontak/Index');
    })->name('kontak');

    Route::get('/booking-layanan', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking-layanan');
    Route::post('/booking-layanan', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking-layanan.store');

    Route::get('/artikel', function () {
        $articlesQuery = Article::query()
            ->with('category:id,name')
            ->where('status', 'published')
            ->latest('published_at')
            ->latest('created_at');

        $articlesPage = $articlesQuery->paginate(6);

        $articles = $articlesPage->map(function (Article $article) {
            return [
                'judul' => $article->title,
                'deskripsi' => $article->description,
                'gambar' => $article->cover_image_url ?? '/images/Artikel_1.jpg',
                'kategori' => $article->category?->name ?? 'Umum',
                'tanggal' => $article->published_at?->translatedFormat('d F Y')
                    ?? $article->created_at->translatedFormat('d F Y'),
                'slug' => $article->slug,
            ];
        });

        return Inertia::render('user/artikel/Index', [
            'articles' => [
                'data' => $articles,
                'current_page' => $articlesPage->currentPage(),
                'last_page' => $articlesPage->lastPage(),
                'per_page' => $articlesPage->perPage(),
                'total' => $articlesPage->total(),
                'from' => $articlesPage->firstItem(),
                'to' => $articlesPage->lastItem(),
            ],
        ]);
    })->name('artikel');

    Route::get('/artikel/{slug}', function (string $slug) {
        $article = Article::query()
            ->with('category:id,name')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $articles = Article::query()
            ->with('category:id,name')
            ->where('status', 'published')
            ->where('slug', '!=', $slug)
            ->latest('published_at')
            ->latest('created_at')
            ->limit(3)
            ->get()
            ->map(function (Article $article) {
                return [
                    'judul' => $article->title,
                    'deskripsi' => $article->description,
                    'gambar' => $article->cover_image_url ?? '/images/Artikel_1.jpg',
                    'kategori' => $article->category?->name ?? 'Umum',
                    'tanggal' => $article->published_at?->translatedFormat('d F Y')
                        ?? $article->created_at->translatedFormat('d F Y'),
                    'slug' => $article->slug,
                ];
            });

        $articleData = [
            'judul' => $article->title,
            'deskripsi' => $article->description,
            'gambar' => $article->cover_image_url ?? '/images/Artikel_1.jpg',
            'kategori' => $article->category?->name ?? 'Umum',
            'tanggal' => $article->published_at?->translatedFormat('d F Y')
                ?? $article->created_at->translatedFormat('d F Y'),
            'slug' => $article->slug,
            'file_path_url' => $article->file_path_url,
            'penulis' => $article->author,
        ];

        return Inertia::render('user/artikel/detail', [
            'article' => $articleData,
            'articles' => $articles,
        ]);
    })->name('artikel.detail');

    // Google OAuth routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    Route::middleware('guest')->group(function () {
        Route::get('/admin/login', function () {
            return Inertia::render('auth/LoginAdminPage', [
                'canResetPassword' => Features::enabled(Features::resetPasswords()),
                'status' => session('status'),
            ]);
        })->name('admin.login');
    });

Route::middleware(['auth'])->group(function () {
    // Tes Online Routes
    Route::get('/tes-online', function () {
        return Inertia::render('user/daftar-layanan/Index');
    })->name('daftar-layanan');

    Route::get('/tes-online/minat-bakat', function () {
        return Inertia::render('user/minat-bakat/Index');
    })->name('tes-online.minat-bakat');
    
    // New Route for Minat Bakat Submission
    Route::post('/tes-online/minat-bakat/mulai', [App\Http\Controllers\OnlineTestController::class, 'start'])
        ->defaults('category', 'minat-bakat')
        ->name('tes-online.minat-bakat.mulai');

    Route::post('/tes-online/minat-bakat/submit', [App\Http\Controllers\OnlineTestSubmitController::class, 'submitMinatBakat'])
        ->name('tes-online.minat-bakat.submit');

    Route::get('/tes-online/minat-bakat/tes', function () {
        $categories = InterestCategory::query()
            ->with(['jobs' => fn ($query) => $query->orderBy('order')])
            ->orderBy('order')
            ->get()
            ->map(fn (InterestCategory $category) => [
                'code' => $category->code,
                'name' => $category->name,
                'instruction' => $category->instruction,
                'has_jobs' => $category->has_jobs,
                'jobs' => $category->jobs->pluck('job_name')->values()->all(),
            ])
            ->values();

        return Inertia::render('user/minat-bakat/Tes', [
            'categories' => $categories,
        ]);
    })->name('tes-online.minat-bakat.tes');

    Route::get('/tes-online/minat-bakat/selesai', function () {
        return Inertia::render('user/minat-bakat/Selesai');
    })->name('tes-online.minat-bakat.selesai');

    Route::get('/tes-online/inteligensi', function () {
        return Inertia::render('user/inteligensi/Index');
    })->name('tes-online.inteligensi');

    // New Route for Inteligensi Submission
    Route::post('/tes-online/inteligensi/mulai', [App\Http\Controllers\OnlineTestController::class, 'start'])
        ->defaults('category', 'inteligensi')
        ->name('tes-online.inteligensi.mulai');

    Route::post('/tes-online/inteligensi/submit', [App\Http\Controllers\OnlineTestSubmitController::class, 'submitInteligensi'])
        ->name('tes-online.inteligensi.submit');

    Route::get('/tes-online/inteligensi/tes', function () {
        $categories = IntelligenceTestCategory::query()
            ->with([
                'questions' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                },
            ])
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function (IntelligenceTestCategory $category) {
                $isMemory = $category->question_type === 'memory';
                $questions = $category->questions->map(function ($question) use ($category) {
                    if ($category->answer_type === 'text') {
                        return $question->question_text ?? '';
                    }

                    return [
                        'pertanyaan' => $question->question_text ?? '',
                        'gambarSoal' => $question->question_image,
                        'opsi' => collect([
                            $question->option_a,
                            $question->option_b,
                            $question->option_c,
                            $question->option_d,
                            $question->option_e,
                        ])
                            ->filter(fn ($option) => filled($option))
                            ->map(function ($option) use ($category) {
                                return [
                                    'tipe' => $category->question_type === 'image' ? 'gambar' : 'teks',
                                    'nilai' => $option,
                                ];
                            })
                            ->values()
                            ->all(),
                    ];
                })->filter()->values()->all();

                $kataHafalan = [];

                if ($isMemory) {
                    $memoryWords = collect($category->questions)
                        ->map(function ($question) {
                            return collect((array) ($question->question_data ?? []))
                                ->get('memory_words', []);
                        })
                        ->flatten()
                        ->filter(fn ($word) => filled($word))
                        ->map(fn ($word) => (string) $word)
                        ->unique()
                        ->values()
                        ->all();

                    $kataHafalan = $memoryWords;
                }

                $instructionText = trim((string) ($category->description ?? ''));
                $durationMinutes = max(1, (int) $category->duration_minutes);
                
                $gambarInstruksi = null;

                if ($isMemory) {
                    $instructionText = 'Hafalkan daftar kata/gambar yang ditampilkan pada sesi instruksi ini. Setelah sesi soal dimulai, jawablah pertanyaan berdasarkan yang Anda hafalkan.';
                    
                    // Cek apakah instruksi di DB berakhiran ekstensi gambar/path
                    if (!empty($category->instruction) && str_contains($category->instruction, 'intelligence-test/instructions')) {
                        $gambarInstruksi = '/storage/' . $category->instruction;
                    } else {
                        $gambarInstruksi = '/images/ist/me-board.svg'; // default bawaan awal
                    }
                } else {
                    // Jika bukan memory, pakai teks normal dari database
                    $instructionText = trim((string) ($category->instruction ?? $category->description ?? ''));
                }

                $instructionText .= ' Total waktu pengerjaan kategori ini: ' . $durationMinutes . ' menit.';

                $tipe = 'pilihan';
                if ($category->question_type === 'numeric' || $category->question_type === 'series') {
                    $tipe = 'angka';
                } elseif ($category->answer_type === 'text') {
                    $tipe = 'isian';
                }

                return [
                    'kode' => $category->code,
                    'tipe' => $tipe,
                    'questionType' => $category->question_type,
                    'waktuInstruksi' => 180,
                    'waktuSoal' => $category->duration_minutes * 60,
                    'instruksi' => $instructionText,
                    'gambarInstruksi' => $gambarInstruksi,
                    'kataHafalan' => $kataHafalan,
                    'soal' => $questions,
                ];
            })
            ->values();

        return Inertia::render('user/inteligensi/Tes', [
            'categories' => $categories,
        ]);
    })->name('tes-online.inteligensi.tes');

    Route::get('/tes-online/inteligensi/selesai', function () {
        return Inertia::render('user/inteligensi/Selesai');
    })->name('tes-online.inteligensi.selesai');

    Route::get('/tes-online/gaya-belajar', function () {
        return Inertia::render('user/gaya-belajar/Index');
    })->name('tes-online.gaya-belajar');

    // New Route for Gaya Belajar Submission
    Route::post('/tes-online/gaya-belajar/mulai', [App\Http\Controllers\OnlineTestController::class, 'start'])
        ->defaults('category', 'gaya-belajar')
        ->name('tes-online.gaya-belajar.mulai');

    Route::post('/tes-online/gaya-belajar/submit', [App\Http\Controllers\OnlineTestSubmitController::class, 'submitGayaBelajar'])
        ->name('tes-online.gaya-belajar.submit');

    Route::get('/tes-online/gaya-belajar/tes', function () {
        $statements = LearningStyleStatement::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(fn (LearningStyleStatement $statement) => [
                'id' => $statement->id,
                'teks' => $statement->statement,
            ])
            ->values();

        return Inertia::render('user/gaya-belajar/Tes', [
            'statements' => $statements,
        ]);
    })->name('tes-online.gaya-belajar.tes');

    Route::get('/tes-online/gaya-belajar/selesai', function () {
        return Inertia::render('user/gaya-belajar/Selesai');
    })->name('tes-online.gaya-belajar.selesai');

    // Dashboard user
    Route::get('/user/dashboard', function (Request $request) {
        $user = $request->user();
        $testSessions = \App\Models\TestSession::with(['report'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($session) {
                $hasReport = $session->has_report;

                return [
                    'id' => $session->id,
                    'test_type' => ucwords(str_replace('_', ' ', $session->test_type)),
                    'date' => $session->created_at->format('j F Y'),
                    'status' => $session->status_badge ?? $session->status,
                    'raw_status' => $session->status,
                    'has_pdf' => $hasReport,
                    'report_view_url' => $hasReport ? route('user.laporan.view', $session->id) : null,
                    'report_download_url' => $hasReport ? route('user.laporan.download', $session->id) : null,
                ];
            });

        return Inertia::render('user/dashboard/Index', [
            'user' => $user,
            'riwayat' => $testSessions,
        ]);
    })->name('userDashboard');

    Route::get('/user/laporan-psikologi/{id}/view', function (Request $request, $id) {
        $session = \App\Models\TestSession::with('report')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (! $session->report) {
            abort(404, 'Laporan PDF belum tersedia.');
        }

        $filePath = storage_path('app/public/' . $session->report->file_path);

        if (! is_file($filePath)) {
            abort(404, 'File laporan tidak ditemukan.');
        }

        return response()->file($filePath);
    })->name('user.laporan.view');

    // Download Laporan Psikologi for User
    Route::get('/user/laporan-psikologi/{id}/download', function (Request $request, $id) {
        $session = \App\Models\TestSession::with('report')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (!$session->report) {
            abort(404, 'Laporan PDF belum tersedia.');
        }

        $filePath = storage_path('app/public/' . $session->report->file_path);

        if (! is_file($filePath)) {
            abort(404, 'File laporan tidak ditemukan.');
        }

        return response()->download($filePath, $session->report->file_name);
    })->name('user.laporan.download');

    // User profile management (named distinctly to avoid clashing with settings profile routes)
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/user/profile', [UserProfileController::class, 'destroy'])->name('user.profile.destroy');

});

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/notifications', [DashboardController::class, 'notifications'])->name('notifications.index');
    Route::post('/admin/notifications/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/admin/bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');

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

    // Psychologists Management
    Route::resource('admin/psychologists', PsychologistController::class)->except(['create', 'edit']);

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
    Route::put('/admin/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.update-status');

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
    Route::get('/admin/asesmen/bank-soal/{batch}/export/excel', [TestTokenController::class, 'exportExcel'])->name('bankSoal.export.excel');
    Route::get('/admin/asesmen/bank-soal/{batch}/export/pdf', [TestTokenController::class, 'exportPdf'])->name('bankSoal.export.pdf');
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
    Route::put('/admin/kelola-pengguna/{id}/role', [App\Http\Controllers\Admin\UserManagementController::class, 'updateRole'])->name('kelolaPengguna.updateRole');
    Route::delete('/admin/kelola-pengguna/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('kelolaPengguna.destroy');

}); 
require __DIR__.'/settings.php';
