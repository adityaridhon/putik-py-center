<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntelligenceTestCategory;

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
                'total_questions' => 20,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan memahami persamaan kata',
                'order' => 1,
            ],
            [
                'code' => 'WA',
                'name' => 'Antonim (WA)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan memahami lawan kata',
                'order' => 2,
            ],
            [
                'code' => 'AN',
                'name' => 'Analogi (AN)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 7,
                'description' => 'Tes kemampuan memahami hubungan antar kata',
                'order' => 3,
            ],
            [
                'code' => 'GE',
                'name' => 'Pengelompokan (GE)',
                'question_type' => 'text',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 8,
                'description' => 'Tes kemampuan mengelompokkan kata',
                'order' => 4,
            ],
            [
                'code' => 'RA',
                'name' => 'Aritmatika (RA)',
                'question_type' => 'numeric',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 10,
                'description' => 'Tes kemampuan berhitung',
                'order' => 5,
            ],
            [
                'code' => 'ZR',
                'name' => 'Deret Angka (ZR)',
                'question_type' => 'series',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 10,
                'description' => 'Tes kemampuan melanjutkan deret angka',
                'order' => 6,
            ],
            [
                'code' => 'FA',
                'name' => 'Gambar (FA)',
                'question_type' => 'image',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 7,
                'description' => 'Tes kemampuan memahami pola gambar',
                'order' => 7,
            ],
            [
                'code' => 'WU',
                'name' => 'Klasifikasi Kata (WU)',
                'question_type' => 'classification',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 9,
                'description' => 'Tes kemampuan mengklasifikasikan kata',
                'order' => 8,
            ],
            [
                'code' => 'ME',
                'name' => 'Memori (ME)',
                'question_type' => 'memory',
                'answer_type' => 'multiple_choice',
                'total_questions' => 20,
                'duration_minutes' => 6,
                'description' => 'Tes kemampuan mengingat',
                'order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            IntelligenceTestCategory::create($category);
        }
    }
}
