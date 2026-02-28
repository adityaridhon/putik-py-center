<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestSession;
use App\Models\TestAnswer;
use App\Models\PsychologicalReport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PsychologicalReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TestSession::with(['user', 'report'])
            ->whereIn('status', ['completed', 'pending_analysis', 'reported']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by test type
        if ($request->filled('test_type') && $request->test_type !== 'semua') {
            $query->where('test_type', $request->test_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'selesai') {
                $query->where('status', 'completed');
            } elseif ($request->status === 'menunggu_analisis') {
                $query->where('status', 'pending_analysis');
            } elseif ($request->status === 'sudah_dilaporkan') {
                $query->where('status', 'reported');
            }
        }

        $sessions = $query->latest()
            ->paginate(10)
            ->through(function ($session) {
                return [
                    'id' => $session->id,
                    'nama' => $session->user->name,
                    'token' => $session->token?->token ?? '#' . str_pad($session->id, 6, '0', STR_PAD_LEFT),
                    'jenisTes' => $this->getTestTypeLabel($session->test_type),
                    'tanggal' => $session->started_at?->format('d F Y'),
                    'status' => $session->has_report ? 'Selesai' : 'Menunggu Analisis',
                ];
            });

        return Inertia::render('admin/laporan-psikologi/Index', [
            'sessions' => $sessions,
            'filters' => $request->only(['search', 'test_type', 'status']),
        ]);
    }

    public function show($id)
    {
        $session = TestSession::with(['user', 'report.uploader'])
            ->findOrFail($id);

        // Get answers grouped by test type
        $intelligenceResults = $this->getIntelligenceResults($session->id);
        $learningStyleResults = $this->getLearningStyleResults($session->id);
        $interestResults = $this->getInterestResults($session->id);

        return Inertia::render('admin/laporan-psikologi/Detail', [
            'session' => [
                'id' => $session->id,
                'participant' => [
                    'name' => $session->user->name,
                    'email' => $session->user->email,
                    'test_date' => $session->started_at?->format('Y-m-d'),
                    'completion_time' => $session->completion_time_minutes . ' menit',
                ],
            ],
            'intelligenceResults' => $intelligenceResults,
            'learningStyleResults' => $learningStyleResults,
            'interestResults' => $interestResults,
            'report' => $session->report ? [
                'id' => $session->report->id,
                'file_name' => $session->report->file_name,
                'file_size' => $session->report->file_size_formatted,
                'uploaded_at' => $session->report->created_at->format('d F Y H:i'),
                'uploaded_by' => $session->report->uploader->name,
            ] : null,
        ]);
    }

    public function uploadReport(Request $request, $id)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $session = TestSession::findOrFail($id);

        // Delete old report if exists
        if ($session->report) {
            $session->report->delete();
        }

        // Store file
        $file = $request->file('file');
        $fileName = 'report_' . $session->id . '_' . time() . '.pdf';
        $filePath = $file->storeAs('psychological-reports', $fileName, 'public');

        // Create report record
        PsychologicalReport::create([
            'test_session_id' => $session->id,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        // Update session status
        $session->update(['status' => 'reported']);

        return redirect()->back()->with('success', 'Laporan berhasil diunggah!');
    }

    public function downloadReport($id)
    {
        $session = TestSession::with('report')->findOrFail($id);

        if (!$session->report) {
            abort(404, 'Report not found');
        }

        return Storage::disk('public')->download(
            $session->report->file_path,
            $session->report->file_name
        );
    }

    public function destroy($id)
    {
        $session = TestSession::findOrFail($id);
        $session->delete();

        return redirect()->back()->with('success', 'Data tes berhasil dihapus!');
    }

    // Helper Methods
    private function getIntelligenceResults($sessionId)
    {
        $answers = TestAnswer::where('test_session_id', $sessionId)
            ->where('test_type', 'intelligence')
            ->get();

        if ($answers->isEmpty()) {
            return ['subtests' => []];
        }

        $grouped = $answers->groupBy('category_name');
        $subtests = [];

        foreach ($grouped as $categoryName => $categoryAnswers) {
            $questions = [];
            
            foreach ($categoryAnswers as $answer) {
                $question = $answer->getQuestionModel();
                
                $questions[] = [
                    'question' => $question?->question_text ?? 'Question not found',
                    'question_type' => 'multiple_choice',
                    'user_answer' => $answer->answer_value,
                ];
            }

            $subtests[] = [
                'name' => $categoryName,
                'questions' => $questions,
            ];
        }

        return ['subtests' => $subtests];
    }

    private function getLearningStyleResults($sessionId)
    {
        $answers = TestAnswer::where('test_session_id', $sessionId)
            ->where('test_type', 'learning_style')
            ->get();

        if ($answers->isEmpty()) {
            return ['statements' => []];
        }

        $statements = [];

        foreach ($answers as $answer) {
            $statement = $answer->getQuestionModel();
            
            $statements[] = [
                'statement' => $statement?->statement ?? 'Statement not found',
                'user_answer' => (int) $answer->answer_value,
            ];
        }

        return ['statements' => $statements];
    }

    private function getInterestResults($sessionId)
    {
        $answers = TestAnswer::where('test_session_id', $sessionId)
            ->where('test_type', 'interest')
            ->get();

        if ($answers->isEmpty()) {
            return ['categories' => []];
        }

        $grouped = $answers->groupBy('category_name');
        $categories = [];

        foreach ($grouped as $categoryName => $categoryAnswers) {
            $questions = [];
            
            foreach ($categoryAnswers as $answer) {
                $job = $answer->getQuestionModel();
                
                $questions[] = [
                    'question' => 'Pilih 1 pekerjaan',
                    'user_answer' => $job?->name ?? $answer->answer_value,
                ];
            }

            $categories[] = [
                'name' => $categoryName,
                'questions' => $questions,
            ];
        }

        return ['categories' => $categories];
    }

    private function getTestTypeLabel($type)
    {
        $labels = [
            'intelligence' => 'Tes Intelegensi',
            'learning_style' => 'Tes Gaya Belajar',
            'interest' => 'Tes Minat Bakat',
            'all' => 'Semua Tes',
        ];

        return $labels[$type] ?? 'Unknown';
    }
}
