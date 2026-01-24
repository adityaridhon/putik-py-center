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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
        ]);

        // Test user dengan 2FA
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Panggil seeder lainnya
        $this->call([
            CompanyProfileSeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
        ]);    }
}
