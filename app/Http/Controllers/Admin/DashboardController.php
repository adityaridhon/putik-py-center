<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Booking;
use App\Models\PsychologicalReport;
use App\Models\TestSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private function growthPercent(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current === 0 ? 0.0 : 100.0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $previousStartOfWeek = Carbon::now()->subWeek()->startOfWeek();
        $previousEndOfWeek = Carbon::now()->subWeek()->endOfWeek();

        $janjiCurrentWeek = Booking::query()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();

        $janjiPreviousWeek = Booking::query()
            ->whereBetween('created_at', [$previousStartOfWeek, $previousEndOfWeek])
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();

        // Samakan sumber data dengan menu Manajemen Laporan Psikologi
        $laporanStatuses = ['completed', 'pending_analysis', 'reported'];

        $laporanCurrentWeek = TestSession::query()
            ->whereIn('status', $laporanStatuses)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $laporanPreviousWeek = TestSession::query()
            ->whereIn('status', $laporanStatuses)
            ->whereBetween('created_at', [$previousStartOfWeek, $previousEndOfWeek])
            ->count();

        // Artikel terbit dihitung dari waktu publish aktual.
        $artikelCurrentWeek = Article::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereBetween('published_at', [$startOfWeek, $endOfWeek])
            ->count();

        $artikelPreviousWeek = Article::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereBetween('published_at', [$previousStartOfWeek, $previousEndOfWeek])
            ->count();

        $dashboardStats = [
            'janjiMingguIni' => $janjiCurrentWeek,
            'laporanPsikologi' => TestSession::query()
                ->whereIn('status', $laporanStatuses)
                ->count(),
            'artikelTerbit' => Article::query()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->count(),
        ];

        $dashboardTrends = [
            'janjiMingguIni' => $this->growthPercent($janjiCurrentWeek, $janjiPreviousWeek),
            'laporanPsikologi' => $this->growthPercent($laporanCurrentWeek, $laporanPreviousWeek),
            'artikelTerbit' => $this->growthPercent($artikelCurrentWeek, $artikelPreviousWeek),
        ];

        $serviceLabels = [
            'children_center' => 'Children Center',
            'konseling_terapi' => 'Konseling Terapi',
            'pemeriksaan_psikologi' => 'Pemeriksaan Psikologi',
        ];

        $statusLabels = [
            'pending' => 'Menunggu',
            'confirmed' => 'Booked',
            'completed' => 'Selesai',
            'cancelled' => 'Batal',
        ];

        $activities = Booking::query()
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function (Booking $booking) use ($serviceLabels, $statusLabels) {
                return [
                    'id' => 'booking_' . $booking->id,
                    'nama_pengguna' => $booking->customer_name,
                    'aktivitas' => $serviceLabels[$booking->service_category] ?? 'Layanan',
                    'tanggal' => Carbon::parse($booking->booking_date)->format('d M Y'),
                    'status' => $statusLabels[$booking->status] ?? 'Menunggu',
                    'sort_date' => clone $booking->updated_at,
                ];
            });

        $testTypeLabels = [
            'interest' => 'Tes Minat Bakat',
            'intelligence' => 'Tes Intelegensi',
            'learning_style' => 'Tes Gaya Belajar',
            'all' => 'Semua Tes',
        ];

        $testStatusLabels = [
            'completed' => 'Selesai',
            'pending_analysis' => 'Menunggu Analisis',
            'reported' => 'Selesai',
        ];

        $testSessions = TestSession::with('user')
            ->whereIn('status', ['completed', 'pending_analysis', 'reported'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($session) use ($testTypeLabels, $testStatusLabels) {
                return [
                    'id' => 'test_' . $session->id,
                    'nama_pengguna' => $session->user ? $session->user->name : 'Peserta',
                    'aktivitas' => $testTypeLabels[$session->test_type] ?? 'Tes Psikologi',
                    'tanggal' => Carbon::parse($session->started_at ?? $session->created_at)->format('d M Y'),
                    'status' => $testStatusLabels[$session->status] ?? 'Menunggu',
                    'sort_date' => clone $session->updated_at,
                ];
            });

        $combinedActivities = $activities->concat($testSessions)
            ->sortByDesc('sort_date')
            ->take(10)
            ->values()
            ->map(function ($item) {
                unset($item['sort_date']);
                return $item;
            });

        return Inertia::render('admin/dashboard/Index', [
            'dashboardStats' => $dashboardStats,
            'dashboardTrends' => $dashboardTrends,
            'activities' => $combinedActivities,
            'notifications' => Auth::user()->unreadNotifications,
        ]);
    }

    public function notifications()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at?->toDateTimeString(),
                ];
            });

        return Inertia::render('admin/notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        Auth::user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }
}
