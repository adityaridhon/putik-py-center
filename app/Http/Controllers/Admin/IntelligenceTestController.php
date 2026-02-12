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
            ->paginate(20);

        return Inertia::render('admin/tes-intelegensi/Edit', [
            'category' => $category,
            'questions' => $questions
        ]);
    }

    // Update Category
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

    // Store Question
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

    // Update Question
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

    // Delete Question
    public function destroyQuestion($id)
    {
        $question = IntelligenceTestQuestion::findOrFail($id);
        $question->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }

    // Delete Category
    public function destroy($id)
    {
        $category = IntelligenceTestCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('intelegensi')->with('success', 'Kategori berhasil dihapus!');
    }
}
