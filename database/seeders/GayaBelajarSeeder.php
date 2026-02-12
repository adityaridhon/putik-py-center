<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningStyleStatement;

class GayaBelajarSeeder extends Seeder
{
    public function run(): void
    {
        // Data pernyataan gaya belajar
        $statements = [
            'Saya lebih suka belajar dengan melihat gambar, diagram, dan grafik',
            'Saya mudah mengingat wajah orang daripada nama mereka',
            'Saya suka membuat catatan dengan warna-warni dan gambar',
            'Saya lebih memahami informasi jika ditampilkan dalam bentuk visual',
            'Saya suka menggunakan highlighter saat membaca',
            'Saya senang menonton video pembelajaran',
            'Saya mudah membayangkan hal-hal dalam pikiran saya',
            'Saya lebih suka membaca instruksi daripada mendengarkannya',
            'Saya sering membuat mind map atau peta konsep',
            'Saya lebih mudah belajar dengan melihat demonstrasi',
            
            'Saya lebih suka mendengarkan penjelasan daripada membaca',
            'Saya mudah mengingat lagu dan lirik musik',
            'Saya suka berdiskusi untuk memahami materi',
            'Saya lebih fokus saat mendengarkan musik latar',
            'Saya sering membaca dengan suara keras untuk memahami',
            'Saya senang mendengarkan podcast atau audiobook',
            'Saya mudah mengingat percakapan yang saya dengar',
            'Saya lebih suka diberitahu daripada ditunjukkan',
            'Saya senang belajar dengan menjelaskan ke orang lain',
            'Saya lebih mudah belajar dalam kelompok diskusi',
            
            'Saya lebih suka belajar sambil bergerak atau berjalan',
            'Saya mudah bosan jika duduk terlalu lama',
            'Saya suka praktek langsung daripada mendengar teori',
            'Saya lebih memahami dengan melakukan eksperimen',
            'Saya suka belajar lewat permainan atau simulasi',
            'Saya senang menggunakan alat peraga saat belajar',
            'Saya lebih mudah mengingat dengan menulis berulang kali',
            'Saya suka membuat model atau prototype',
            'Saya belajar lebih baik dengan trial and error',
            'Saya senang fieldtrip dan kunjungan lapangan',
        ];

        foreach ($statements as $index => $statementText) {
            LearningStyleStatement::create([
                'statement' => $statementText,
                'order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
