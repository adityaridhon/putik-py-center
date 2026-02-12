<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call(ServiceSeeder::class);

        // Admin user tanpa 2FA
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
            ]
        );

        // Test user dengan 2FA
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
            ]
        );
        // Panggil seeder lainnya
        $this->call([
            CompanyProfileSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            ArticleCategorySeeder::class,
            ArticleSeeder::class,
            MinatBakatSeeder::class,
            LearningStyleStatementSeeder::class,
        ]);    }
}
