<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestTokenBatch;
use App\Models\TestToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TestTokenSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {

            // Buat 1 batch contoh
            $batch = TestTokenBatch::create([
                'test_type' => 'Tes Minat Bakat',
                'total_tokens' => 20,
                'expired_at' => now()->addMonth(),
                'note' => 'Seeder Dummy Data'
            ]);

            $tokens = [];

            for ($i = 0; $i < 20; $i++) {
                $tokens[] = [
                    'batch_id' => $batch->id,
                    'token' => 'MB-' . strtoupper(Str::random(8)),
                    'is_used' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TestToken::insert($tokens);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}