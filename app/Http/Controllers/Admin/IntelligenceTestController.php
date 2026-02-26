<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntelligenceTestCategory;
use App\Models\IntelligenceTestQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IntelligenceTestController extends Controller
{
    // Index - List semua kategori 
    public function index()
    {
        $categories = IntelligenceTestCategory::orderBy('order')->get();

        return Inertia::render('admin/tes-intelegensi/Index', [
            'categories' => $categories
        ]);
    }

    // Edit - Kelola soal per kategori
    public function edit($id)
    {
        $category = IntelligenceTestCategory::findOrFail($id);
        
        $questions = $category->questions()
            ->orderBy('order')
            ->get();

        return Inertia::render('admin/tes-intelegensi/Edit', [
            'category' => $category,
            'questions' => [
                'data' => $questions,
                'total' => $questions->count(),
            ]
        ]);
    }

    // Update Kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'duration_minutes' => 'nullable|integer|min:1',
            'total_questions' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'instruction' => 'nullable|string',
        ]);

        $category = IntelligenceTestCategory::findOrFail($id);
        $category->update(array_filter($validated));

        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    // Store soal
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:intelligence_test_categories,id',
            'question_text' => 'required|string',
            'question_image' => 'nullable|string',
            'question_data' => 'nullable|array',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
            'explanation' => 'nullable|string',
        ]);

        $maxOrder = IntelligenceTestQuestion::where('category_id', $validated['category_id'])
            ->max('order') ?? 0;

        IntelligenceTestQuestion::create([
            ...$validated,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    // Bulk Store Questions
    public function bulkStoreQuestions(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:intelligence_test_categories,id',
        ]);

        $category = IntelligenceTestCategory::findOrFail($request->category_id);
        $isImageType = $category->question_type === 'image';
        $isNumberType = in_array($category->question_type, ['numeric', 'series']);

        $rules = [
            'category_id' => 'required|exists:intelligence_test_categories,id',
            'deleted_question_ids' => 'nullable|array',
            'deleted_question_ids.*' => 'exists:intelligence_test_questions,id',
            'questions.*.id' => 'nullable|exists:intelligence_test_questions,id',
            'questions.*.question_text' => 'nullable|string',
            'questions.*.question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'questions.*.question_data' => 'nullable|array',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
        ];

        if ($isImageType) {
            // For image type
            $rules['questions.*.option_a'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['questions.*.option_a_text'] = 'nullable|string';
            $rules['questions.*.option_b'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['questions.*.option_b_text'] = 'nullable|string';
            $rules['questions.*.option_c'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['questions.*.option_c_text'] = 'nullable|string';
            $rules['questions.*.option_d'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['questions.*.option_d_text'] = 'nullable|string';
            $rules['questions.*.option_e'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['questions.*.option_e_text'] = 'nullable|string';
        } else {
            // For text/numeric type
            $rules['questions.*.option_a'] = 'nullable|string';
            $rules['questions.*.option_b'] = 'nullable|string';
            $rules['questions.*.option_c'] = 'nullable|string';
            $rules['questions.*.option_d'] = 'nullable|string';
            $rules['questions.*.option_e'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Handle deleted questions
        $deleteCount = 0;
        if (!empty($validated['deleted_question_ids'])) {
            $deleteCount = IntelligenceTestQuestion::whereIn('id', $validated['deleted_question_ids'])
                ->where('category_id', $validated['category_id'])
                ->delete();
        }

        $maxOrder = IntelligenceTestQuestion::where('category_id', $validated['category_id'])
            ->max('order') ?? 0;

        $successCount = 0;
        $updateCount = 0;
        $questionsInput = $request->input('questions', []);

        foreach ($questionsInput as $index => $questionData) {
            // Check upd
            $isUpdate = isset($questionData['id']) && !empty($questionData['id']);
            $existingQuestion = null;
            
            if ($isUpdate) {
                $existingQuestion = IntelligenceTestQuestion::find($questionData['id']);
                if (!$existingQuestion) {
                    continue; 
                }
            }
            
            $questionImagePath = null;
            
            // Handle image upload soal
            if ($request->hasFile("questions.{$index}.question_image")) {
                $questionImagePath = $request->file("questions.{$index}.question_image")
                    ->store('intelligence-test/questions', 'public');
            } elseif ($isUpdate && $existingQuestion) {
                $questionImagePath = $existingQuestion->question_image;
            }

            // Prepare pilgan
            $optionData = [];
            foreach (['a', 'b', 'c', 'd', 'e'] as $optionLabel) {
                if ($isImageType) {
                    // preveiw untuk soal gambar
                    if ($request->hasFile("questions.{$index}.option_{$optionLabel}")) {
                        $optionData["option_{$optionLabel}"] = $request->file("questions.{$index}.option_{$optionLabel}")
                            ->store('intelligence-test/options', 'public');
                    } elseif ($isUpdate && $existingQuestion) {
                        // Keep existing option image if no new file uploaded
                        $optionData["option_{$optionLabel}"] = $existingQuestion->{"option_{$optionLabel}"};
                    } else {
                        $optionData["option_{$optionLabel}"] = $questionData["option_{$optionLabel}_text"] ?? null;
                    }
                } else {
                    // untuk teks/tdk gambar
                    $optionData["option_{$optionLabel}"] = $questionData["option_{$optionLabel}"] ?? null;
                }
            }

            // Untuk multiple choice, uppercase (A, B, C, D, E)
            $correctAnswer = $questionData['correct_answer'];
            if ($category->answer_type === 'multiple_choice' && !$isNumberType) {
                $correctAnswer = strtoupper($correctAnswer);
            }

            $dataToSave = [
                'category_id' => $validated['category_id'],
                'question_text' => $questionData['question_text'] ?? null,
                'question_image' => $questionImagePath,
                'question_data' => $questionData['question_data'] ?? null,
                'option_a' => $optionData['option_a'],
                'option_b' => $optionData['option_b'],
                'option_c' => $optionData['option_c'],
                'option_d' => $optionData['option_d'],
                'option_e' => $optionData['option_e'],
                'correct_answer' => $correctAnswer,
                'explanation' => $questionData['explanation'] ?? null,
            ];

            if ($isUpdate) {
                $existingQuestion->update($dataToSave);
                $updateCount++;
            } else {
                $dataToSave['order'] = $maxOrder + $index + 1;
                IntelligenceTestQuestion::create($dataToSave);
                $successCount++;
            }
        }

        $message = [];
        if ($successCount > 0) {
            $message[] = "{$successCount} soal baru berhasil ditambahkan";
        }
        if ($updateCount > 0) {
            $message[] = "{$updateCount} soal berhasil diperbarui";
        }
        if ($deleteCount > 0) {
            $message[] = "{$deleteCount} soal berhasil dihapus";
        }
        
        $finalMessage = !empty($message) ? implode(', ', $message) . '!' : 'Tidak ada perubahan!';
        return redirect()->back()->with('success', $finalMessage);
    }

    // Update Soal
    public function updateQuestion(Request $request, $id)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_image' => 'nullable|string',
            'question_data' => 'nullable|array',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
            'explanation' => 'nullable|string',
        ]);

        $question = IntelligenceTestQuestion::findOrFail($id);
        $question->update($validated);

        return redirect()->back()->with('success', 'Soal berhasil diupdate!');
    }

    // Delete Soal
    public function destroyQuestion($id)
    {
        $question = IntelligenceTestQuestion::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }

    // Delete Kategori
    public function destroy($id)
    {
        $category = IntelligenceTestCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('intelegensi')->with('success', 'Kategori berhasil dihapus!');
    }
}
