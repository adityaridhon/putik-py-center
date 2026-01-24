<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    // Halaman Edit Profil (Dashboard)
    public function index()
    {
        // Ambil data pertama (karena cuma ada 1 profil perusahaan)
        $profile = CompanyProfile::first(); 

        return Inertia::render('admin/ProfilUmum', [
            'profile' => $profile
        ]);
    }

    // Proses Update Data
    public function update(Request $request)
    {
        $profile = CompanyProfile::firstOrFail();

        // 1. Validasi
        $validated = $request->validate([
            'company_name' => 'required|string|max:150',
            'headline'     => 'nullable|string',
            'about'        => 'nullable|string',
            'phone'        => 'nullable|string',
            'email'        => 'nullable|email',
            'instagram'    => 'nullable|string',
            'address'      => 'nullable|string',
            'logo'         => 'nullable|image|max:2048', 
            'landing_image'=> 'nullable|image|max:2048',
        ]);

       // 2. Ambil data text
        $data = $request->only([
            'company_name', 'headline', 'about', 'phone', 
            'email', 'instagram', 'address'
        ]);

        // 3. Handle Logo
        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $data['logo'] = $request->file('logo')->store('company', 'public');
        }

        // 4. Handle Landing Image
        if ($request->hasFile('landing_image')) {
            if ($profile->landing_image) Storage::disk('public')->delete($profile->landing_image);
            $data['landing_image'] = $request->file('landing_image')->store('company', 'public');
        }

        // 5. Simpan
        $profile->update($data);

        // 6. Redirect ke halaman Manajemen Konten
        return redirect()->route('konten')->with('success', 'Profil berhasil disimpan.');
    }
}