<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\ArticleCategory;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ArticleCategory::all();

        foreach (range(1, 10) as $i) {
            $title = "Contoh Artikel $i";

            Article::create([
                'title' => $title,
                'author' => 'Admin',
                'category_id' => $categories->random()->id,
                'description' => 'Ini adalah deskripsi dummy untuk artikel ke-' . $i,
                'slug' => Str::slug($title),
                'status' => 'published',
                'file_path' => null,
                'cover_image' => null,
                'published_at' => Carbon::now(),
            ]);
        }
    }
}
