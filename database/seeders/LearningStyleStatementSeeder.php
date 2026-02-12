<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningStyleStatement;

class LearningStyleStatementSeeder extends Seeder
{
    public function run(): void
    {
        $statements = [
            'Saya lebih mudah memahami materi melalui gambar atau diagram.',
            'Saya lebih suka belajar dengan mendengarkan penjelasan.',
            'Saya lebih mudah mengingat informasi dengan praktik langsung.',
            'Saya senang membuat catatan saat belajar.',
            'Saya lebih fokus saat belajar dalam suasana tenang.',
            'Saya memahami materi lebih baik saat berdiskusi.',
            'Saya suka menggunakan warna dalam mencatat.',
            'Saya lebih cepat belajar dengan video.',
            'Saya suka mencoba langsung daripada hanya membaca.',
            'Saya mudah terganggu oleh suara sekitar.'
        ];

        foreach ($statements as $index => $statement) {
            LearningStyleStatement::create([
                'statement' => $statement,
                'order' => $index + 1,
            ]);
        }
    }
}
