<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        // Admin user tanpa 2FA
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
            ]
        );

        $admin->forceFill(['role' => 'admin'])->save();

        // Test user
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $testUser->forceFill(['role' => 'user'])->save();
        
        // Panggil seeder lainnya
        $this->call([
            CompanyProfileSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            ArticleCategorySeeder::class,
            ArticleSeeder::class,
            MinatBakatSeeder::class,
            GayaBelajarSeeder::class,
            IntelligenceTestSeeder::class,
            TestTokenSeeder::class,
            UserTestSeeder::class, // Create users dengan test sessions
        ]);
    }
}
