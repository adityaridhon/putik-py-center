<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TestToken;
use App\Models\TestTokenBatch;
use App\Models\TestSession;
use App\Models\TestAnswer;
use App\Models\IntelligenceTestQuestion;
use App\Models\LearningStyleStatement;
use App\Models\InterestJob;
use App\Models\PsychologicalReport;
use Carbon\Carbon;

class UserTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("Starting User Test Seeder...");

        // Create test token batch for users
        $batch = TestTokenBatch::create([
            'test_type' => 'all',
            'total_tokens' => 30,
            'expired_at' => now()->addDays(90),
            'note' => 'Batch Dummy Users untuk testing - ' . now()->format('Y-m-d'),
        ]);

        // Create test users dengan berbagai level aktivitas
        $users = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'completed', 'days_ago' => 15],
                    ['type' => 'learning_style', 'status' => 'reported', 'days_ago' => 10],
                    ['type' => 'interest', 'status' => 'completed', 'days_ago' => 5],
                ]
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'reported', 'days_ago' => 20],
                    ['type' => 'interest', 'status' => 'completed', 'days_ago' => 3],
                ]
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'tests' => [
                    ['type' => 'learning_style', 'status' => 'completed', 'days_ago' => 7],
                ]
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'completed', 'days_ago' => 12],
                    ['type' => 'interest', 'status' => 'reported', 'days_ago' => 4],
                ]
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki.pratama@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'completed', 'days_ago' => 2],
                ]
            ],
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya.anggraini@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'reported', 'days_ago' => 25],
                    ['type' => 'learning_style', 'status' => 'reported', 'days_ago' => 18],
                    ['type' => 'interest', 'status' => 'completed', 'days_ago' => 11],
                    ['type' => 'intelligence', 'status' => 'completed', 'days_ago' => 1],
                ]
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@example.com',
                'tests' => [
                    ['type' => 'learning_style', 'status' => 'completed', 'days_ago' => 14],
                    ['type' => 'interest', 'status' => 'completed', 'days_ago' => 6],
                ]
            ],
            [
                'name' => 'Lina Kartika',
                'email' => 'lina.kartika@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'reported', 'days_ago' => 30],
                    ['type' => 'learning_style', 'status' => 'reported', 'days_ago' => 22],
                    ['type' => 'interest', 'status' => 'reported', 'days_ago' => 16],
                ]
            ],
            [
                'name' => 'Reza Auditore',
                'email' => 'reza.auditore@example.com',
                'tests' => [
                    ['type' => 'interest', 'status' => 'completed', 'days_ago' => 8],
                ]
            ],
            [
                'name' => 'Putri Maharani',
                'email' => 'putri.maharani@example.com',
                'tests' => [
                    ['type' => 'intelligence', 'status' => 'reported', 'days_ago' => 35],
                    ['type' => 'learning_style', 'status' => 'completed', 'days_ago' => 9],
                ]
            ],
            [
                'name' => 'Farhan Abdullah',
                'email' => 'farhan.abdullah@example.com',
                'tests' => [] // User tanpa test history
            ],
        ];

        foreach ($users as $userData) {
            // Create or get user
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password123'),
                    'email_verified_at' => now(),
                    'created_at' => now()->subDays(rand(60, 180)),
                ]
            );

            $this->command->info("Processing user: {$userData['name']}");

            // Create test sessions untuk user ini
            foreach ($userData['tests'] as $testData) {
                $this->createTestSession($user, $batch, $testData);
            }

            $this->command->line("  ✓ Created {$userData['name']} with " . count($userData['tests']) . " test(s)");
        }

        $this->command->info("✅ User test seeder completed successfully!");
    }

    private function createTestSession($user, $batch, $testData)
    {
        $testDate = now()->subDays($testData['days_ago']);
        
        // Create token for this test
        $token = TestToken::create([
            'batch_id' => $batch->id,
            'token' => 'TKN' . strtoupper(substr(md5($user->email . $testData['type'] . time() . rand()), 0, 6)),
            'is_used' => true,
            'used_at' => $testDate,
        ]);

        // Create test session
        $duration = rand(30, 65); // Minutes
        $session = TestSession::create([
            'user_id' => $user->id,
            'test_token_id' => $token->id,
            'test_type' => $testData['type'],
            'status' => $testData['status'],
            'started_at' => $testDate,
            'completed_at' => $testDate->copy()->addMinutes($duration),
            'completion_time_minutes' => $duration,
        ]);

        // Create test answers sesuai jenis tes
        $this->createTestAnswers($session, $testData['type']);

        // Jika status reported, create psychological report
        if ($testData['status'] === 'reported') {
            $this->createPsychologicalReport($session, $testDate);
        }

        return $session;
    }

    private function createTestAnswers($session, $testType)
    {
        switch ($testType) {
            case 'intelligence':
                $this->createIntelligenceAnswers($session);
                break;
            case 'learning_style':
                $this->createLearningStyleAnswers($session);
                break;
            case 'interest':
                $this->createInterestAnswers($session);
                break;
        }
    }

    private function createIntelligenceAnswers($session)
    {
        // Ambil 30 soal acak dari berbagai kategori
        $questions = IntelligenceTestQuestion::inRandomOrder()->limit(30)->get();
        
        foreach ($questions as $question) {
            // 70% kemungkinan jawaban benar
            $isCorrect = rand(1, 100) <= 70;
            
            if ($isCorrect) {
                $answer = $question->correct_answer;
            } else {
                $options = ['A', 'B', 'C', 'D'];
                $wrongOptions = array_diff($options, [$question->correct_answer]);
                $answer = $wrongOptions[array_rand($wrongOptions)];
            }

            TestAnswer::create([
                'test_session_id' => $session->id,
                'test_type' => 'intelligence',
                'category_name' => null, // Can be populated if category available
                'question_type' => 'intelligence_question',
                'question_id' => $question->id,
                'answer_value' => $answer,
            ]);
        }
    }

    private function createLearningStyleAnswers($session)
    {
        // Ambil semua statements (27 statements)
        $statements = LearningStyleStatement::all();
        
        foreach ($statements as $statement) {
            TestAnswer::create([
                'test_session_id' => $session->id,
                'test_type' => 'learning_style',
                'category_name' => null,
                'question_type' => 'learning_statement',
                'question_id' => $statement->id,
                'answer_value' => (string) rand(1, 3), // Skala 1-3
            ]);
        }
    }

    private function createInterestAnswers($session)
    {
        // Ambil semua jobs
        $jobs = InterestJob::all();
        
        foreach ($jobs as $job) {
            // Random pilihan: 60% suka, 40% tidak suka untuk variasi
            $answer = rand(1, 100) <= 60 ? 'suka' : 'tidak_suka';
            
            TestAnswer::create([
                'test_session_id' => $session->id,
                'test_type' => 'interest',
                'category_name' => null, // Can be populated if category available
                'question_type' => 'interest_job',
                'question_id' => $job->id,
                'answer_value' => $answer,
            ]);
        }
    }

    private function createPsychologicalReport($session, $testDate)
    {
        PsychologicalReport::create([
            'test_session_id' => $session->id,
            'file_path' => 'psychological-reports/dummy_report_' . $session->id . '.pdf',
            'file_name' => 'Laporan_Psikologi_' . $session->user->name . '_' . $session->test_type . '.pdf',
            'file_size' => rand(800000, 2500000), // Random size 800KB - 2.5MB
            'uploaded_by' => 1, // Admin
            'created_at' => $testDate->copy()->addDays(rand(2, 5)),
        ]);
    }
}
