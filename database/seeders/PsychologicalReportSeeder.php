<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestSession;
use App\Models\TestAnswer;
use App\Models\User;
use App\Models\IntelligenceTestQuestion;
use App\Models\IntelligenceTestCategory;
use App\Models\LearningStyleStatement;
use App\Models\InterestJob;
use App\Models\InterestCategory;
use Carbon\Carbon;

class PsychologicalReportSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Creating a test user...');
            $users = collect([User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ])]);
        }

        // Get questions
        $intelligenceQuestions = IntelligenceTestQuestion::with('category')->get();
        $learningStatements = LearningStyleStatement::all();
        $interestJobs = InterestJob::with('category')->get();

        // Create 5 test sessions
        foreach (range(1, 5) as $index) {
            $user = $users->random();
            $startedAt = Carbon::now()->subDays(rand(1, 30));
            $completedAt = $startedAt->copy()->addMinutes(rand(30, 60));
            
            $session = TestSession::create([
                'user_id' => $user->id,
                'test_type' => 'all',
                'status' => $index <= 3 ? 'completed' : 'pending_analysis',
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'completion_time_minutes' => $completedAt->diffInMinutes($startedAt),
            ]);

            // Add Intelligence Test Answers (sample from each category)
            if ($intelligenceQuestions->isNotEmpty()) {
                $categories = $intelligenceQuestions->groupBy('category.code');
                
                foreach ($categories as $categoryCode => $questions) {
                    $sampleQuestions = $questions->take(2); // Take 2 questions per category
                    
                    foreach ($sampleQuestions as $question) {
                        TestAnswer::create([
                            'test_session_id' => $session->id,
                            'test_type' => 'intelligence',
                            'category_name' => $question->category->name ?? $categoryCode,
                            'question_type' => 'intelligence_question',
                            'question_id' => $question->id,
                            'answer_value' => $this->generateIntelligenceAnswer($question),
                        ]);
                    }
                }
            }

            // Add Learning Style Answers (all statements)
            if ($learningStatements->isNotEmpty()) {
                foreach ($learningStatements->take(10) as $statement) {
                    TestAnswer::create([
                        'test_session_id' => $session->id,
                        'test_type' => 'learning_style',
                        'category_name' => null,
                        'question_type' => 'learning_statement',
                        'question_id' => $statement->id,
                        'answer_value' => (string) rand(1, 3), // Scale 1-3
                    ]);
                }
            }

            // Add Interest Test Answers (sample from each category)
            if ($interestJobs->isNotEmpty()) {
                $interestCategories = $interestJobs->groupBy('category.name');
                
                foreach ($interestCategories as $categoryName => $jobs) {
                    $sampleJob = $jobs->random();
                    
                    TestAnswer::create([
                        'test_session_id' => $session->id,
                        'test_type' => 'interest',
                        'category_name' => $categoryName ?? 'Unknown Category',
                        'question_type' => 'interest_job',
                        'question_id' => $sampleJob->id,
                        'answer_value' => $sampleJob->name ?? $sampleJob->job_name ?? 'Job ' . $sampleJob->id,
                    ]);
                }
            }
        }

        $this->command->info('Psychological report test data created successfully!');
    }

    private function generateIntelligenceAnswer($question)
    {
        $answers = ['A', 'B', 'C', 'D'];
        
        // Priority: return correct answer, or random if not set
        if ($question->correct_answer) {
            return $question->correct_answer;
        }
        
        return $answers[array_rand($answers)];
    }
}
