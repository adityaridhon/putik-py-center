<?php

namespace App\Http\Controllers;

use App\Models\TestToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineTestController extends Controller
{
    private array $testTypes = [
        'minat-bakat' => 'interest',
        'inteligensi' => 'intelligence',  // Note: the category variable uses pinyin or correct spelling, check route! Route is 'inteligensi'
        'gaya-belajar' => 'learning_style',
    ];

    public function start(Request $request, $category)
    {
        // Category in URL might be intelegensi or inteligensi? 
        // routes/web.php uses 'inteligensi' for GET. GenerateToken uses 'intelegensi'! We need to handle this mismatch.
        $batchTestTypeMap = [
            'minat-bakat' => 'minat-bakat',
            'inteligensi' => 'intelegensi', // map the URL param 'inteligensi' to match generate token DB 'intelegensi'
            'gaya-belajar' => 'gaya-belajar',
        ];

        if (!array_key_exists($category, $this->testTypes)) {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggalLahir' => 'required|date|before_or_equal:today',
            'tanggalTes' => 'required|date',
            'jenisKelamin' => 'required|in:Pria,Wanita',
            'token' => 'required|string',
        ]);

        $batchTestType = $batchTestTypeMap[$category];

        // Find token
        $token = TestToken::with('batch')
            ->where('token', strtoupper($validated['token']))
            ->first();

        if (!$token) {
            return back()->withErrors(['token' => 'Token tidak valid atau tidak ditemukan.']);
        }

        if ($token->is_used) {
            return back()->withErrors(['token' => 'Token ini sudah digunakan.']);
        }

        if ($token->batch->test_type !== $batchTestType) {
            return back()->withErrors(['token' => 'Token ini tidak valid untuk kategori tes ini.']);
        }

        if (now()->startOfDay()->gt($token->batch->expired_at)) {
            return back()->withErrors(['token' => 'Token ini sudah kadaluarsa.']);
        }

        if (\Carbon\Carbon::parse($validated['tanggalTes'])->startOfDay()->gt($token->batch->expired_at)) {
            return back()->withErrors(['tanggalTes' => 'Tanggal tes melebihi masa berlaku token.']);
        }

        try {
            DB::beginTransaction();

            // Tandai token segera terpakai atau biarkan ditandai saat submit hasil akhir?
            // Biasanya token dianggap terpakai setelah mulai tes, tapi request user spesifik: status "valid"
            $token->update([
                'is_used' => true,
                'used_at' => now(),
            ]);

            // Save to server session to be used during the test execution
            session([
                "active_test_session_{$category}" => [
                    'test_type' => $this->testTypes[$category],
                    'test_token_id' => $token->id,
                    'user_info' => $validated
                ]
            ]);

            DB::commit();

            return redirect()->route("tes-online.{$category}.tes");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['token' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
