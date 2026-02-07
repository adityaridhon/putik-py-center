<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InterestCategory;
use App\Models\InterestJob;

class MinatBakatSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori A-I
        $categories = [
            'A' => ['Polisi Lalu Lintas', 'Insinyur Sipil', 'Akuntan', 'Ilmuwati', 'Penjual Hasil Mode', 'Seniman', 'Wartawati', 'Pianis Konser', 'Guru Sekolah Dasar', 'Sekretaris', 'Penata Busana', 'Dokter'],
            'B' => ['Perakit Komputer', 'Personalia', 'Insinyur Kimia Industri', 'Penyiar Radio', 'Artis Profesional', 'Pengarang', 'Pemain Musik Orkestra', 'Psikolog Pendidikan', 'Pegawai Administrasi', 'Seniman Pot Keramik', 'Ahli Bedah', 'Guru Olah Raga'],
            'C' => ['Auditor', 'Ahli Meteorologi', 'Customer service Bank', 'Guru kesenian', 'Penulis Drama', 'Komponis', 'Kepala Panti Asuhan', 'Resepsionis', 'Penata Rambut', 'Dokter Hewan', 'Pramugari', 'Ahli Rekayasa Industri'],
            'D' => ['Ahli Biologi', 'Agen Biro Periklanan', 'Dekorator Interior', 'Ahli Sejarah', 'Kritikus Musik', 'Aktivis LSM', 'Ahli Perkreditan', 'Antropolog', 'Apoteker', 'Ahli Pertamanan', 'Ahli Elektronika', 'Penilai/Auditor pajak'],
            'E' => ['Pembawa Acara', 'Perancang Pakaian', 'Editor Buku', 'Guru Musik', 'Pemuka Agama', 'Kepala Administrasi', 'Florist', 'Psikiater', 'Guru Olah Raga', 'Teknisi Industri', 'Guru matematika', 'Ahli Pertanian'],
            'F' => ['Fotografer', 'Penulis majalah', 'Pemain Orgel (Organ)', 'Relawan Palang Merah', 'Pegawai Bank', 'Desainer Grafis', 'Perawat', 'Ahli Farmasi', 'Peternak', 'Analis Sistem Komputer', 'Ahli Botani', 'Eksportir & Importir'],
            'G' => ['Kritikus Buku', 'Ahli Pustaka Musik', 'Aktivis Komunitas', 'Pegawai Kantor', 'Fisioterais', 'Ahli Rontgent', 'Petani bunga', 'Pembuat Perhiasan', 'Ahli TataBuku', 'Ahli Astronomi', 'Model', 'Penata Panggung'],
            'H' => ['Vokalis Band', 'Konsultan', 'Ahli Tata Negara', 'Trainer', 'Bidan', 'Tour Guide', 'Instalator Listrik', 'Developer Multimedia', 'Ahli Geologi', 'Petugas Hubungan Masyarakat', 'Pelukis', 'Penulis Sandiwara Radio'],
            'I' => ['Petugas KOMNAS HAM', 'Pegawai Tata Usaha', 'Koki/Chef', 'Dokter Anak', 'Atlit', 'Kontraktor', 'Petugas Pajak', 'Laboran', 'Manager Promosi', 'perancang motif Tekstil', 'Penyair', 'Kompuser'],
        ];

        foreach ($categories as $code => $jobs) {
            $category = InterestCategory::create([
                'code' => $code,
                'name' => 'Kategori ' . $code,
                'instruction' => 'Pilih pekerjaan yang paling Anda minati dari daftar berikut.',
                'has_jobs' => true,
                'order' => ord($code) - 64, // A=1, B=2, dst.
            ]);

            foreach ($jobs as $index => $jobName) {
                InterestJob::create([
                    'category_id' => $category->id,
                    'job_name' => $jobName,
                    'order' => $index + 1,
                ]);
            }
        }

        // Kategori Terakhir (Essay)
        InterestCategory::create([
            'code' => 'ESSAY',
            'name' => 'Pekerjaan Favorit',
            'instruction' => 'Tuliskan 3 (Tiga) pekerjaan yang paling ingin anda lakukan dan yang paling anda sukai',
            'has_jobs' => false,
            'order' => 10,
        ]);
    }
}
