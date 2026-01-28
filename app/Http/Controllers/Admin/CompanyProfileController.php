<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $profile = CompanyProfile::first();
        $services = Service::paginate(5, ['*'], 'services_page');
       $clients = Client::paginate(5, ['*'], 'clients_page');
        
        return Inertia::render('admin/profil-umum/Index', [
            'profile' => $profile,
            'services' => $services,
            'clients' => $clients,
        ]);
    }

    public function edit()
    {
        $profile = CompanyProfile::first(); 

        return Inertia::render('admin/profil-umum/Edit', [
            'profile' => $profile
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:150',
            'headline'     => 'nullable|string',
            'about'        => 'nullable|string',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:100',
            'instagram'    => 'nullable|string|max:100',
            'address'      => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048', 
            'landing_image'=> 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $profile = CompanyProfile::firstOrNew(['id' => 1]);

        $profile->company_name = $validated['company_name'] ?? $profile->company_name;
        $profile->headline = $validated['headline'] ?? $profile->headline;
        $profile->about = $validated['about'] ?? $profile->about;
        $profile->phone = $validated['phone'] ?? $profile->phone;
        $profile->email = $validated['email'] ?? $profile->email;
        $profile->instagram = $validated['instagram'] ?? $profile->instagram;
        $profile->address = $validated['address'] ?? $profile->address;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $profile->logo = $request->file('logo')->store('company', 'public');
        }

        if ($request->hasFile('landing_image') && $request->file('landing_image')->isValid()) {
            if ($profile->landing_image && Storage::disk('public')->exists($profile->landing_image)) {
                Storage::disk('public')->delete($profile->landing_image);
            }
            $profile->landing_image = $request->file('landing_image')->store('company', 'public');
        }

        // Simpan profil
        $profile->save();

        return redirect()->route('konten')->with('success', 'Profil berhasil disimpan.');
    }
}