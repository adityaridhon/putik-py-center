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
        $statements = LearningStyleStatement::orderBy('order')
            ->paginate(10);

        return Inertia::render('admin/tes-gaya-belajar/Index', [
            'statements' => $statements
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/tes-gaya-belajar/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'statement' => 'required|string|min:10|max:500',
        ]);

        $maxOrder = LearningStyleStatement::max('order') ?? 0;

        LearningStyleStatement::create([
            'statement' => $validated['statement'],
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('gayaBelajar')->with('success', 'Pernyataan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'statement' => 'required|string|min:10|max:500',
        ]);

        $statement = LearningStyleStatement::findOrFail($id);
        $statement->update($validated);

        return redirect()->back()->with('success', 'Pernyataan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $statement = LearningStyleStatement::findOrFail($id);
        $statement->delete();

        return redirect()->back()->with('success', 'Pernyataan berhasil dihapus!');
    }
}

