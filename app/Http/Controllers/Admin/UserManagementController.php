<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->withCount(['testSessions as jumlah_tes' => function($q) {
                $q->whereIn('status', ['completed', 'pending_analysis', 'reported']);
            }])
            ->where('id', '!=', auth()->id()); // Exclude current admin

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'nama-az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'nama-za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'jumlah-tes-terbanyak':
                    $query->orderByDesc('jumlah_tes');
                    break;
                case 'jumlah-tes-tersedikit':
                    $query->orderBy('jumlah_tes', 'asc');
                    break;
                case 'terbaru':
                    $query->latest('created_at');
                    break;
                case 'terlama':
                    $query->oldest('created_at');
                    break;
                default:
                    $query->latest('created_at');
            }
        } else {
            $query->latest('created_at');
        }

        $users = $query->paginate(10)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'jumlah_tes' => $user->jumlah_tes ?? 0,
                ];
            });

        return Inertia::render('admin/kelola-pengguna/Index', [
            'users' => $users,
            'filters' => $request->only(['search', 'sort']),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        // Get test history
        $testHistory = TestSession::where('user_id', $id)
            ->whereIn('status', ['completed', 'pending_analysis', 'reported'])
            ->with(['token'])
            ->latest('started_at')
            ->get()
            ->map(function ($session) {
                // Get token string
                $tokenString = $session->token?->token ?? '#' . str_pad($session->id, 6, '0', STR_PAD_LEFT);
                
                return [
                    'id' => $session->id,
                    'token' => $tokenString,
                    'jenis_tes' => $this->getTestTypeLabel($session->test_type),
                    'tanggal' => $session->started_at?->format('Y-m-d'),
                    'tanggal_formatted' => $session->started_at?->format('d F Y'),
                    'status' => $this->getStatusLabel($session->status),
                    'status_badge' => $session->status,
                ];
            });

        return Inertia::render('admin/kelola-pengguna/Detail', [
            'user' => [
                'id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('d F Y'),
            ],
            'testHistory' => $testHistory,
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow deleting current admin
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        // Soft delete related test sessions
        $user->testSessions()->delete();
        
        // Delete user
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }

    // Helper methods
    private function getTestTypeLabel($type)
    {
        $labels = [
            'intelligence' => 'Tes Intelegensi',
            'learning_style' => 'Tes Gaya Belajar',
            'interest' => 'Tes Minat Bakat',
            'all' => 'Semua Tes',
        ];

        return $labels[$type] ?? 'Unknown';
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'in_progress' => 'Sedang Berlangsung',
            'completed' => 'Menunggu Analisis',
            'pending_analysis' => 'Menunggu Analisis',
            'reported' => 'Selesai',
        ];

        return $labels[$status] ?? 'Unknown';
    }
}
