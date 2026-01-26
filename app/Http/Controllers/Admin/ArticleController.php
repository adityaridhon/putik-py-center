<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
            ->latest()
            ->get();

        $categories = ArticleCategory::select('id', 'name')->get();

        return Inertia::render('admin/Artikel', [
            'articles'   => $articles,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'category_id'  => 'required|exists:article_categories,id',
            'description'  => 'required|string',
            'status'       => 'required|in:draft,published,archived',
            'file_path'    => 'required|file|mimes:pdf|max:5120',
            'cover_image'  => 'nullable|image|max:2048',
        ]);

        $validated['file_path'] = $request->file('file_path')
            ->store('articles/pdf', 'public');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('articles/cover', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()
            ->route('artikel')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function show(Article $artikel)
    {
        $artikel->load('category');

        return Inertia::render('admin/ArtikelDetail', [
            'artikel' => $artikel,
        ]);
    }

    public function update(Request $request, Article $artikel)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'category_id'  => 'required|exists:article_categories,id',
            'description'  => 'required|string',
            'status'       => 'required|in:draft,published,archived',
            'file_path'    => 'nullable|file|mimes:pdf|max:5120',
            'cover_image'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($artikel->file_path);

            $validated['file_path'] = $request->file('file_path')
                ->store('articles/pdf', 'public');
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($artikel->cover_image);

            $validated['cover_image'] = $request->file('cover_image')
                ->store('articles/cover', 'public');
        }

        if ($validated['title'] !== $artikel->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] ??= now();
        } else {
            $validated['published_at'] = null;
        }

        $artikel->update($validated);

        return redirect()
            ->route('artikel')
            ->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $artikel)
    {
        Storage::disk('public')->delete([
            $artikel->file_path,
            $artikel->cover_image,
        ]);

        $artikel->delete();

        return redirect()
            ->route('artikel')
            ->with('success', 'Artikel berhasil dihapus');
    }
}
