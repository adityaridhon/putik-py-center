<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PsychologistController extends Controller
{
    public function index()
    {
        return response()->json(Psychologist::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'specialization']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('psychologists', 'public');
        }

        Psychologist::create($data);

        return back()->with('success', 'Psikolog berhasil ditambahkan.');
    }

    public function update(Request $request, Psychologist $psychologist)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'specialization']);

        if ($request->hasFile('photo')) {
            if ($psychologist->photo) {
                Storage::disk('public')->delete($psychologist->photo);
            }

            $data['photo'] = $request->file('photo')->store('psychologists', 'public');
        }

        $psychologist->update($data);

        return back()->with('success', 'Psikolog berhasil diperbarui.');
    }

    public function destroy(Psychologist $psychologist)
    {
        if ($psychologist->photo) {
            Storage::disk('public')->delete($psychologist->photo);
        }

        $psychologist->delete();

        return back()->with('success', 'Psikolog berhasil dihapus.');
    }
}
