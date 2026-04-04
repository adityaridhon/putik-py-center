<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestTokenBatch;
use App\Models\TestToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class TestTokenController extends Controller
{
    public function index()
    {
        $batches = TestTokenBatch::withCount('tokens')
            ->latest()
            ->get();

        return Inertia::render('admin/bank-soal/Index', [
            'batches' => $batches
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/bank-soal/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|in:minat-bakat,intelegensi,gaya-belajar',
            'total_tokens' => 'required|integer|min:1|max:1000',
            'expired_at' => 'required|date|after_or_equal:today',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $batch = TestTokenBatch::create($validated);

            $tokens = [];

            for ($i = 0; $i < $validated['total_tokens']; $i++) {
                $tokens[] = [
                    'batch_id' => $batch->id,
                    'token' => strtoupper(Str::random(10)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TestToken::insert($tokens);

            DB::commit();

            return redirect()
                ->route('bankSoal')
                ->with('success', 'Token berhasil dibuat!');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal generate token. Silakan coba lagi.');
        }
    }

    public function show(TestTokenBatch $batch)
    {
        $batch->load('tokens');

        return Inertia::render('admin/bank-soal/Detail', [
            'batch' => $batch
        ]);
    }

    public function edit(TestTokenBatch $batch)
    {
        return Inertia::render('admin/bank-soal/Edit', [
            'batch' => $batch
        ]);
    }

    public function update(Request $request, TestTokenBatch $batch)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|in:minat-bakat,intelegensi,gaya-belajar',
            'expired_at' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            $batch->update($validated);

            return redirect()
                ->route('bankSoal')
                ->with('info', 'Batch token berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui batch.');
        }
    }

    public function destroy(TestTokenBatch $batch)
    {
        try {
            $batch->delete();

            return redirect()
                ->route('bankSoal')
                ->with('success', 'Batch token berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus batch.');
        }
    }
}