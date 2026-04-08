<?php

namespace App\Http\Controllers;

use App\Models\TestSession;
use App\Models\TestAnswer;
use App\Models\TestToken;
use App\Models\IntelligenceTestCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class OnlineTestSubmitController extends Controller
{
    public function submitMinatBakat(Request $request)
    {
        $sessionData = session('active_test_session_minat-bakat');
        if (!$sessionData) {
            return redirect()->route('tes-online.minat-bakat')
                ->withErrors(['token' => 'Sesi tes tidak valid atau sudah kedaluwarsa.']);
        }

        $token = TestToken::find($sessionData['test_token_id']);
        if (!$token) {
            return redirect()->route('tes-online.minat-bakat')->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        $user = $request->user();

        DB::beginTransaction();
        try {
            $testSession = TestSession::create([
                'user_id' => $user->id,
                'test_token_id' => $token->id,
                'test_type' => 'interest',
                'status' => 'pending_analysis',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $answersData = $request->input('answers', []);
            
            foreach ($answersData['ranking'] ?? [] as $category => $ranks) {
                foreach ($ranks as $index => $rank) {
                    TestAnswer::create([
                        'test_session_id' => $testSession->id,
                        'test_type' => 'interest',
                        'category_name' => $category,
                        'question_type' => 'interest_job',
                        'question_id' => $index + 1,
                        'answer_value' => $rank,
                    ]);
                }
            }
            foreach ($answersData['isian'] ?? [] as $category => $items) {
                foreach ($items as $index => $text) {
                    TestAnswer::create([
                        'test_session_id' => $testSession->id,
                        'test_type' => 'interest',
                        'category_name' => $category,
                        'question_type' => 'interest_job_isian',
                        'question_id' => $index + 1,
                        'answer_value' => $text,
                    ]);
                }
            }

            DB::commit();
            session()->forget('active_test_session_minat-bakat');

            return redirect()->route('tes-online.minat-bakat.selesai');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function submitInteligensi(Request $request)
    {
        $sessionData = session('active_test_session_inteligensi');
        if (!$sessionData) {
            return redirect()->route('tes-online.inteligensi')
                ->withErrors(['token' => 'Sesi tes tidak valid atau sudah kedaluwarsa.']);
        }

        $token = TestToken::find($sessionData['test_token_id']);
        if (!$token) {
            return redirect()->route('tes-online.inteligensi')->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        $user = $request->user();

        DB::beginTransaction();
        try {
            $testSession = TestSession::create([
                'user_id' => $user->id,
                'test_token_id' => $token->id,
                'test_type' => 'intelligence',
                'status' => 'completed',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $answersData = $request->input('answers', []);

            $questionIdMap = IntelligenceTestCategory::query()
                ->with([
                    'questions' => function ($query) {
                        $query->where('is_active', true)->orderBy('order');
                    },
                ])
                ->whereIn('code', array_keys($answersData))
                ->get()
                ->mapWithKeys(function (IntelligenceTestCategory $category) {
                    return [
                        $category->code => $category->questions
                            ->mapWithKeys(fn ($question) => [$question->order => $question->id])
                            ->all(),
                    ];
                })
                ->all();

            foreach ($answersData as $category => $answers) {
                foreach ($answers as $index => $val) {
                    $order = $index + 1;
                    $resolvedQuestionId = $questionIdMap[$category][$order] ?? $order;

                    TestAnswer::create([
                        'test_session_id' => $testSession->id,
                        'test_type' => 'intelligence',
                        'category_name' => $category,
                        'question_type' => 'intelligence_question',
                        'question_id' => $resolvedQuestionId,
                        'answer_value' => $val,
                    ]);
                }
            }

            DB::commit();
            session()->forget('active_test_session_inteligensi');

            return redirect()->route('tes-online.inteligensi.selesai');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function submitGayaBelajar(Request $request)
    {
        $sessionData = session('active_test_session_gaya-belajar');
        if (!$sessionData) {
            return redirect()->route('tes-online.gaya-belajar')
                ->withErrors(['token' => 'Sesi tes tidak valid atau sudah kedaluwarsa.']);
        }

        $token = TestToken::find($sessionData['test_token_id']);
        if (!$token) {
            return redirect()->route('tes-online.gaya-belajar')->withErrors(['token' => 'Token tidak ditemukan.']);
        }

        $user = $request->user();

        DB::beginTransaction();
        try {
            $testSession = TestSession::create([
                'user_id' => $user->id,
                'test_token_id' => $token->id,
                'test_type' => 'learning_style',
                'status' => 'pending_analysis',
                'started_at' => now(),
                'completed_at' => now(),
            ]);

            $answersData = $request->input('answers', []);
            foreach ($answersData as $item) {
                TestAnswer::create([
                    'test_session_id' => $testSession->id,
                    'test_type' => 'learning_style',
                    'category_name' => 'gaya_belajar',
                    'question_type' => 'learning_statement',
                    'question_id' => $item['id'] ?? 0,
                    'answer_value' => $item['jawaban'] ?? '',
                ]);
            }

            DB::commit();
            session()->forget('active_test_session_gaya-belajar');

            return redirect()->route('tes-online.gaya-belajar.selesai');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

