<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{

    public function run(): void
    {
        // Pastikan hanya ada 1 record profil perusahaan dengan id = 1
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Putik Psychology Center',
                'headline' => 'Mitra terpercaya dalam pemecahan masalah psikologis untuk individu, pendidikan, dan perusahaan.',
                'about' => 'Putik didirikan sebagai lembaga yang bergerak di bidang pelayanan psikologi, meliputi Children Center, layanan konseling, terapi, dll...',
                'phone' => '08125581350',
                'email' => 'putik_pc@yahoo.com',
                'instagram' => '@putikpsycenter',
                'address' => 'Jl. Telindung No. 141 B Balikpapan',
            ]
        );
    }
}
