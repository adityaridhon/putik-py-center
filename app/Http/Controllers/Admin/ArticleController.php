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
            ->paginate(5); 

        $recentArticles = Article::with('category')
            ->latest()
            ->limit(5)
            ->get();

        // Hitung jumlah artikel per kategori
        $articlesByCategory = Article::select('category_id', \DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->map(function($item) {
                return [
                    'kategori' => $item->category->name,
                    'kategori_id' => $item->category_id,
                    'jumlah' => $item->total,
                ];
            });

        $categories = ArticleCategory::select('id', 'name')->get();

        return Inertia::render('admin/manajemen-artikel/Index', [
            'articles'   => $articles,
            'recentArticles' => $recentArticles,
            'articlesByCategory' => $articlesByCategory,
            'categories' => $categories,
        ]);
    }

    public function show(Article $article)
    {
        $article->load('category');

        return Inertia::render('admin/manajemen-artikel/Detail', [
            'artikel' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'author' => $article->author,
                'category_id' => $article->category_id,
                'category' => $article->category ? [
                    'id' => $article->category->id,
                    'name' => $article->category->name,
                ] : null,
                'description' => $article->description,
                'status' => $article->status,
                'file_path' => $article->file_path,
                'cover_image' => $article->cover_image,
                'cover_image_url' => $article->cover_image_url,
                'file_path_url' => $article->file_path_url,
                'published_at' => $article->published_at?->toISOString(),
                'created_at' => $article->created_at->toISOString(),
                'updated_at' => $article->updated_at->toISOString(),
            ],
        ]);
    }

    public function create()
    {
        $categories = ArticleCategory::select('id', 'name')->get();

        return Inertia::render('admin/manajemen-artikel/Create', [
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
            'file_path'    => 'nullable|file|mimes:pdf|max:5120',
            'cover_image'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')
                ->store('articles/pdf', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('articles/cover', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('article')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $article)
    {
        $article->load('category');

        $categories = ArticleCategory::select('id', 'name')->get();

        return Inertia::render('admin/manajemen-artikel/Edit', [
            'artikel' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'author' => $article->author,
                'category_id' => $article->category_id,
                'description' => $article->description,
                'status' => $article->status,
                'file_path' => $article->file_path,
                'cover_image' => $article->cover_image,
                'published_at' => $article->published_at,
            ],
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Article $article)
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

        // Update basic fields
        $article->title = $request->input('title');
        $article->author = $request->input('author');
        $article->category_id = $request->input('category_id');
        $article->description = $request->input('description');
        $article->status = $request->input('status');

        // Handle file upload
        if ($request->hasFile('file_path')) {
            if ($article->file_path) {
                Storage::disk('public')->delete($article->file_path);
            }
            $article->file_path = $request->file('file_path')
                ->store('articles/pdf', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $article->cover_image = $request->file('cover_image')
                ->store('articles/cover', 'public');
        }

        // Update slug if title changed
        if ($request->input('title') !== $article->getOriginal('title')) {
            $article->slug = Str::slug($request->input('title'));
        }

        // Handle published_at
        if ($request->input('status') === 'published' && !$article->published_at) {
            $article->published_at = now();
        } elseif ($request->input('status') !== 'published') {
            $article->published_at = null;
        }

        $article->save();

        return redirect()->route('article')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        // Delete files only if they exist
        if ($article->file_path) {
            Storage::disk('public')->delete($article->file_path);
        }
        
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return redirect()->route('article')->with('success', 'Artikel berhasil dihapus');
    }
}
