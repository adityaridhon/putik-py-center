<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Konseling Individual',
                'description' => 'Layanan konseling pribadi untuk membantu mengatasi masalah psikologis, emosional, dan perilaku secara individual dengan pendekatan profesional dan rahasia.',
                'is_active' => true,
            ],
            [
                'name' => 'Tes Psikologi',
                'description' => 'Pemeriksaan psikologis komprehensif meliputi tes intelegensi, minat bakat, kepribadian, dan berbagai aspek psikologis lainnya dengan alat tes terstandarisasi.',
                'is_active' => true,
            ],
            [
                'name' => 'Children Center',
                'description' => 'Program khusus untuk anak-anak dengan berbagai layanan seperti terapi bermain, konseling anak, dan program pengembangan kemampuan anak.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}