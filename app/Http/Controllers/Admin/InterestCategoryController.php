<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InterestCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = InterestCategory::orderBy('order')->get();
        return Inertia::render('admin/tes-minat-bakat/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mendapatkan kategori beserta pekerjaannya
        $category = InterestCategory::with(['jobs' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($id);

        return Inertia::render('admin/tes-minat-bakat/Edit', [
            'category' => $category,
            'jobs' => $category->jobs
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = InterestCategory::findOrFail($id);

        $request->validate([
            'instruction' => 'nullable|string',
        ]);

        $category->update([
            'instruction' => $request->instruction,
        ]);

        return redirect()->back()->with('success', 'Instruksi berhasil diperbarui.');
    }
}
