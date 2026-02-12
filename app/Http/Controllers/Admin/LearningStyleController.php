<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningStyleStatement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningStyleController extends Controller
{
    public function index()
    {
        $statements = LearningStyleStatement::orderBy('order')->get();

        return Inertia::render('admin/asesmen/GayaBelajar/Index', [
            'statements' => $statements
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/asesmen/GayaBelajar/Create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'statement' => 'required|string|min:5',
            ]);

            $order = LearningStyleStatement::max('order') + 1;

            LearningStyleStatement::create([
                'statement' => $validated['statement'],
                'order' => $order
            ]);

            return redirect()
                ->route('admin.gaya-belajar.index')
                ->with('success', 'Pernyataan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit(LearningStyleStatement $gaya_belajar)
    {
        return Inertia::render('admin/asesmen/GayaBelajar/Edit', [
            'statement' => $gaya_belajar
        ]);
    }

    public function update(Request $request, LearningStyleStatement $gaya_belajar)
    {
        try {
            $validated = $request->validate([
                'statement' => 'required|string|min:5',
            ]);

            $gaya_belajar->update($validated);

            return redirect()
                ->route('admin.gaya-belajar.index')
                ->with('success', 'Pernyataan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(LearningStyleStatement $gaya_belajar)
    {
        try {
            $gaya_belajar->delete();

            return redirect()
                ->route('admin.gaya-belajar.index')
                ->with('warning', 'Pernyataan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
