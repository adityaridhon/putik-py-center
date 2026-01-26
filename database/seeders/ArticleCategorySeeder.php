<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ArticleCategory;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Teknologi',
            'Pendidikan',
            'Kesehatan',
            'Bisnis',
            'Lingkungan'
        ];

        foreach ($categories as $category) {
            ArticleCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
