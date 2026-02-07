<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestJob;
use Illuminate\Http\Request;

class InterestJobController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:interest_categories,id',
            'job_name' => 'required|string|max:255',
        ]);

        // Get max order for this category to append to end
        $maxOrder = InterestJob::where('category_id', $request->category_id)->max('order') ?? 0;

        InterestJob::create([
            'category_id' => $request->category_id,
            'job_name' => $request->job_name,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $job = InterestJob::findOrFail($id);

        $request->validate([
            'job_name' => 'required|string|max:255',
        ]);

        $job->update([
            'job_name' => $request->job_name,
        ]);

        return redirect()->back()->with('success', 'Pekerjaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = InterestJob::findOrFail($id);
        $job->delete();

        return redirect()->back()->with('success', 'Pekerjaan berhasil dihapus.');
    }
}
