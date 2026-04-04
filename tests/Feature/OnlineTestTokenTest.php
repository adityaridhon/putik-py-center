<?php

use App\Models\User;

test('token valid untuk kategori yang benar dan masa berlaku belum lewat bisa memulai test', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $batch = \App\Models\TestTokenBatch::create([
        'test_type' => 'minat-bakat',
        'total_tokens' => 1,
        'expired_at' => now()->addDays(2)->format('Y-m-d'),
    ]);

    $token = \App\Models\TestToken::create([
        'batch_id' => $batch->id,
        'token' => 'VALIDTOKEN',
        'is_used' => false,
    ]);

    $response = $this->post(route('tes-online.minat-bakat.mulai'), [
        'nama' => 'John Doe',
        'tanggalLahir' => now()->subYears(20)->format('Y-m-d'),
        'tanggalTes' => now()->format('Y-m-d'),
        'jenisKelamin' => 'Pria',
        'token' => 'VALIDTOKEN',
    ]);

    $response->assertRedirect(route('tes-online.minat-bakat.tes'));
    $this->assertDatabaseHas('test_tokens', [
        'id' => $token->id,
        'is_used' => true,
    ]);
});

test('token kadaluarsa ditolak', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $batch = \App\Models\TestTokenBatch::create([
        'test_type' => 'minat-bakat',
        'total_tokens' => 1,
        'expired_at' => now()->subDays(1)->format('Y-m-d'),
    ]);

    $token = \App\Models\TestToken::create([
        'batch_id' => $batch->id,
        'token' => 'EXPIREDTOK',
        'is_used' => false,
    ]);

    $response = $this->from(route('tes-online.minat-bakat'))
        ->post(route('tes-online.minat-bakat.mulai'), [
            'nama' => 'John Doe',
            'tanggalLahir' => now()->subYears(20)->format('Y-m-d'),
            'tanggalTes' => now()->format('Y-m-d'),
            'jenisKelamin' => 'Pria',
            'token' => 'EXPIREDTOK',
        ]);

    $response->assertRedirect(route('tes-online.minat-bakat'));
    $response->assertSessionHasErrors('token');
    
    $this->assertDatabaseHas('test_tokens', [
        'id' => $token->id,
        'is_used' => false,
    ]);
});

test('token salah kategori ditolak', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $batch = \App\Models\TestTokenBatch::create([
        'test_type' => 'gaya-belajar',
        'total_tokens' => 1,
        'expired_at' => now()->addDays(2)->format('Y-m-d'),
    ]);

    $token = \App\Models\TestToken::create([
        'batch_id' => $batch->id,
        'token' => 'WRONGCATTO',
        'is_used' => false,
    ]);

    $response = $this->from(route('tes-online.minat-bakat'))
        ->post(route('tes-online.minat-bakat.mulai'), [
            'nama' => 'John Doe',
            'tanggalLahir' => now()->subYears(20)->format('Y-m-d'),
            'tanggalTes' => now()->format('Y-m-d'),
            'jenisKelamin' => 'Pria',
            'token' => 'WRONGCATTO',
        ]);

    $response->assertRedirect(route('tes-online.minat-bakat'));
    $response->assertSessionHasErrors('token');
});

test('token sudah dipakai ditolak', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $batch = \App\Models\TestTokenBatch::create([
        'test_type' => 'minat-bakat',
        'total_tokens' => 1,
        'expired_at' => now()->addDays(2)->format('Y-m-d'),
    ]);

    $token = \App\Models\TestToken::create([
        'batch_id' => $batch->id,
        'token' => 'USEDTOKENN',
        'is_used' => true,
        'used_at' => now(),
    ]);

    $response = $this->from(route('tes-online.minat-bakat'))
        ->post(route('tes-online.minat-bakat.mulai'), [
            'nama' => 'John Doe',
            'tanggalLahir' => now()->subYears(20)->format('Y-m-d'),
            'tanggalTes' => now()->format('Y-m-d'),
            'jenisKelamin' => 'Pria',
            'token' => 'USEDTOKENN',
        ]);

    $response->assertRedirect(route('tes-online.minat-bakat'));
    $response->assertSessionHasErrors('token');
});
