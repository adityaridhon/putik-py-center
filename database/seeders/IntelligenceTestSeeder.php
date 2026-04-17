<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntelligenceTestCategory;
use App\Models\IntelligenceTestQuestion;

class IntelligenceTestSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'code' => 'SE',
                'name' => 'Sinonim (SE)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan memahami persamaan kata',
                'instruction' => 'Pilih kata yang paling dekat maknanya dengan kata pada soal.',
                'order' => 1,
                'questions' => [
                    [
                        'question_text' => 'Sinonim dari kata "rajin" adalah ....',
                        'option_a' => 'malas',
                        'option_b' => 'tekun',
                        'option_c' => 'letih',
                        'option_d' => 'lalai',
                        'correct_answer' => 'tekun',
                    ],
                    [
                        'question_text' => 'Sinonim dari kata "cepat" adalah ....',
                        'option_a' => 'lekas',
                        'option_b' => 'pelan',
                        'option_c' => 'diam',
                        'option_d' => 'sering',
                        'correct_answer' => 'lekas',
                    ],
                    [
                        'question_text' => 'Sinonim dari kata "indah" adalah ....',
                        'option_a' => 'buruk',
                        'option_b' => 'cantik',
                        'option_c' => 'sempit',
                        'option_d' => 'pudar',
                        'correct_answer' => 'cantik',
                    ],
                ],
            ],
            [
                'code' => 'WA',
                'name' => 'Antonim (WA)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan memahami lawan kata',
                'instruction' => 'Pilih lawan kata yang paling tepat.',
                'order' => 2,
                'questions' => [
                    [
                        'question_text' => 'Lawan kata "besar" adalah ....',
                        'option_a' => 'luas',
                        'option_b' => 'tinggi',
                        'option_c' => 'kecil',
                        'option_d' => 'tebal',
                        'correct_answer' => 'kecil',
                    ],
                    [
                        'question_text' => 'Lawan kata "maju" adalah ....',
                        'option_a' => 'naik',
                        'option_b' => 'turun',
                        'option_c' => 'mundur',
                        'option_d' => 'lurus',
                        'correct_answer' => 'mundur',
                    ],
                    [
                        'question_text' => 'Lawan kata "ramai" adalah ....',
                        'option_a' => 'riuh',
                        'option_b' => 'sunyi',
                        'option_c' => 'penuh',
                        'option_d' => 'padat',
                        'correct_answer' => 'sunyi',
                    ],
                ],
            ],
            [
                'code' => 'AN',
                'name' => 'Analogi (AN)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 7,
                'description' => 'Tes kemampuan memahami hubungan antar kata',
                'instruction' => 'Temukan hubungan kata yang setara dengan pasangan contoh.',
                'order' => 3,
                'questions' => [
                    [
                        'question_text' => 'Dokter : Rumah Sakit = Guru : ....',
                        'option_a' => 'Sekolah',
                        'option_b' => 'Kebun',
                        'option_c' => 'Kantin',
                        'option_d' => 'Pasar',
                        'correct_answer' => 'Sekolah',
                    ],
                    [
                        'question_text' => 'Ikan : Air = Burung : ....',
                        'option_a' => 'Tanah',
                        'option_b' => 'Udara',
                        'option_c' => 'Api',
                        'option_d' => 'Batu',
                        'correct_answer' => 'Udara',
                    ],
                    [
                        'question_text' => 'Mata : Melihat = Telinga : ....',
                        'option_a' => 'Mencium',
                        'option_b' => 'Mengecap',
                        'option_c' => 'Mendengar',
                        'option_d' => 'Meraba',
                        'correct_answer' => 'Mendengar',
                    ],
                ],
            ],
            [
                'code' => 'GE',
                'name' => 'Pengelompokan (GE)',
                'question_type' => 'classification',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 8,
                'description' => 'Tes kemampuan mengelompokkan kata',
                'instruction' => 'Pilih kata yang tidak termasuk satu kelompok.',
                'order' => 4,
                'questions' => [
                    [
                        'question_text' => 'Yang tidak termasuk buah adalah ....',
                        'option_a' => 'Mangga',
                        'option_b' => 'Apel',
                        'option_c' => 'Wortel',
                        'option_d' => 'Jeruk',
                        'correct_answer' => 'Wortel',
                    ],
                    [
                        'question_text' => 'Yang tidak termasuk alat transportasi adalah ....',
                        'option_a' => 'Mobil',
                        'option_b' => 'Sepeda',
                        'option_c' => 'Lemari',
                        'option_d' => 'Kereta',
                        'correct_answer' => 'Lemari',
                    ],
                    [
                        'question_text' => 'Yang tidak termasuk mamalia adalah ....',
                        'option_a' => 'Kuda',
                        'option_b' => 'Sapi',
                        'option_c' => 'Ayam',
                        'option_d' => 'Kucing',
                        'correct_answer' => 'Ayam',
                    ],
                ],
            ],
            [
                'code' => 'RA',
                'name' => 'Aritmatika (RA)',
                'question_type' => 'numeric',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 10,
                'description' => 'Tes kemampuan berhitung',
                'instruction' => 'Pilih hasil hitung yang benar.',
                'order' => 5,
                'questions' => [
                    [
                        'question_text' => '18 + 24 = ....',
                        'option_a' => '40',
                        'option_b' => '41',
                        'option_c' => '42',
                        'option_d' => '43',
                        'correct_answer' => '42',
                    ],
                    [
                        'question_text' => '9 x 7 = ....',
                        'option_a' => '56',
                        'option_b' => '63',
                        'option_c' => '72',
                        'option_d' => '49',
                        'correct_answer' => '63',
                    ],
                    [
                        'question_text' => '84 : 12 = ....',
                        'option_a' => '6',
                        'option_b' => '7',
                        'option_c' => '8',
                        'option_d' => '9',
                        'correct_answer' => '7',
                    ],
                ],
            ],
            [
                'code' => 'ZR',
                'name' => 'Deret Angka (ZR)',
                'question_type' => 'series',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 10,
                'description' => 'Tes kemampuan melanjutkan deret angka',
                'instruction' => 'Pilih angka yang tepat untuk melanjutkan deret.',
                'order' => 6,
                'questions' => [
                    [
                        'question_text' => '2, 4, 6, 8, ....',
                        'option_a' => '9',
                        'option_b' => '10',
                        'option_c' => '11',
                        'option_d' => '12',
                        'correct_answer' => '10',
                    ],
                    [
                        'question_text' => '3, 6, 12, 24, ....',
                        'option_a' => '30',
                        'option_b' => '36',
                        'option_c' => '42',
                        'option_d' => '48',
                        'correct_answer' => '48',
                    ],
                    [
                        'question_text' => '1, 4, 9, 16, ....',
                        'option_a' => '20',
                        'option_b' => '21',
                        'option_c' => '24',
                        'option_d' => '25',
                        'correct_answer' => '25',
                    ],
                ],
            ],
            [
                'code' => 'FA',
                'name' => 'Gambar (FA)',
                'question_type' => 'image',
                'answer_type' => 'multiple_choice',
                'total_questions' => 1,
                'duration_minutes' => 7,
                'description' => 'Tes kemampuan memahami pola gambar',
                'instruction' => 'Perhatikan pola gambar lalu pilih opsi gambar yang tepat.',
                'order' => 7,
                'questions' => [
                    [
                        'question_text' => 'Pilih bentuk yang berbeda dari pola.',
                        'question_image' => '/images/ist/fa-q1.svg',
                        'option_a' => '/images/ist/fa-a.svg',
                        'option_b' => '/images/ist/fa-b.svg',
                        'option_c' => '/images/ist/fa-c.svg',
                        'option_d' => '/images/ist/fa-d.svg',
                        'correct_answer' => '/images/ist/fa-d.svg',
                    ],
                ],
            ],
            [
                'code' => 'WU',
                'name' => 'Klasifikasi Kata (WU)',
                'question_type' => 'classification',
                'answer_type' => 'multiple_choice',
                'total_questions' => 3,
                'duration_minutes' => 9,
                'description' => 'Tes kemampuan mengklasifikasikan kata',
                'instruction' => 'Pilih jawaban yang paling tepat berdasarkan pengetahuan umum.',
                'order' => 8,
                'questions' => [
                    [
                        'question_text' => 'Hari setelah Senin adalah ....',
                        'option_a' => 'Selasa',
                        'option_b' => 'Rabu',
                        'option_c' => 'Kamis',
                        'option_d' => 'Jumat',
                        'correct_answer' => 'Selasa',
                    ],
                    [
                        'question_text' => 'Ibukota Indonesia adalah ....',
                        'option_a' => 'Bandung',
                        'option_b' => 'Jakarta',
                        'option_c' => 'Surabaya',
                        'option_d' => 'Yogyakarta',
                        'correct_answer' => 'Jakarta',
                    ],
                    [
                        'question_text' => 'Bulan setelah Maret adalah ....',
                        'option_a' => 'April',
                        'option_b' => 'Mei',
                        'option_c' => 'Juni',
                        'option_d' => 'Juli',
                        'correct_answer' => 'April',
                    ],
                ],
            ],
            [
                'code' => 'ME',
                'name' => 'Memori (ME)',
                'question_type' => 'memory',
                'answer_type' => 'multiple_choice',
                'total_questions' => 9,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan mengingat',
                'instruction' => 'Hafalkan daftar kata pada sesi instruksi. Setelah itu jawab soal pilihan ganda berdasarkan kata yang telah Anda hafalkan.',
                'order' => 9,
                'questions' => [
                    [
                        'question_text' => 'Manakah kata yang terdapat pada daftar hafalan?',
                        'option_a' => 'BUNGA',
                        'option_b' => 'NASI',
                        'option_c' => 'IKAN',
                        'option_d' => 'MEJA',
                        'correct_answer' => 'BUNGA',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang tidak terdapat pada daftar hafalan?',
                        'option_a' => 'PERKAKAS',
                        'option_b' => 'BURUNG',
                        'option_c' => 'SEPEDA',
                        'option_d' => 'PENSIL',
                        'correct_answer' => 'SEPEDA',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang terdapat pada daftar hafalan?',
                        'option_a' => 'ROTI',
                        'option_b' => 'JENDELA',
                        'option_c' => 'GELAS',
                        'option_d' => 'BOLA',
                        'correct_answer' => 'JENDELA',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang tidak terdapat pada daftar hafalan?',
                        'option_a' => 'KAPAL',
                        'option_b' => 'JAMUR',
                        'option_c' => 'PENSIL',
                        'option_d' => 'PAYUNG',
                        'correct_answer' => 'PAYUNG',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang terdapat pada daftar hafalan?',
                        'option_a' => 'KERTAS',
                        'option_b' => 'GARPU',
                        'option_c' => 'MOBIL',
                        'option_d' => 'KURSI',
                        'correct_answer' => 'KERTAS',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang tidak terdapat pada daftar hafalan?',
                        'option_a' => 'LILIN',
                        'option_b' => 'PENSIL',
                        'option_c' => 'PISANG',
                        'option_d' => 'BURUNG',
                        'correct_answer' => 'PISANG',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang terdapat pada daftar hafalan?',
                        'option_a' => 'JAMUR',
                        'option_b' => 'SABUN',
                        'option_c' => 'PIRING',
                        'option_d' => 'KUNCI',
                        'correct_answer' => 'JAMUR',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang tidak terdapat pada daftar hafalan?',
                        'option_a' => 'BUNGA',
                        'option_b' => 'JENDELA',
                        'option_c' => 'TOPI',
                        'option_d' => 'KAPAL',
                        'correct_answer' => 'TOPI',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                    [
                        'question_text' => 'Manakah kata yang terdapat pada daftar hafalan?',
                        'option_a' => 'KACA',
                        'option_b' => 'PENSIL',
                        'option_c' => 'ROTI',
                        'option_d' => 'GUNUNG',
                        'correct_answer' => 'PENSIL',
                        'question_data' => [
                            'memory_words' => ['BUNGA', 'PERKAKAS', 'BURUNG', 'JENDELA', 'KAPAL', 'LILIN', 'KERTAS', 'JAMUR', 'PENSIL'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $questions = $category['questions'];
            unset($category['questions']);

            $categoryModel = IntelligenceTestCategory::updateOrCreate(
                ['code' => $category['code']],
                $category,
            );

            $orders = [];
            foreach ($questions as $index => $question) {
                $order = $index + 1;
                $orders[] = $order;

                IntelligenceTestQuestion::updateOrCreate(
                    [
                        'category_id' => $categoryModel->id,
                        'order' => $order,
                    ],
                    [
                        'question_text' => $question['question_text'] ?? null,
                        'question_image' => $question['question_image'] ?? null,
                        'question_data' => $question['question_data'] ?? null,
                        'option_a' => $question['option_a'] ?? null,
                        'option_b' => $question['option_b'] ?? null,
                        'option_c' => $question['option_c'] ?? null,
                        'option_d' => $question['option_d'] ?? null,
                        'option_e' => $question['option_e'] ?? null,
                        'correct_answer' => $question['correct_answer'] ?? '',
                        'explanation' => $question['explanation'] ?? null,
                        'is_active' => true,
                    ],
                );
            }

            IntelligenceTestQuestion::query()
                ->where('category_id', $categoryModel->id)
                ->whereNotIn('order', $orders)
                ->delete();
        }
    }
}
