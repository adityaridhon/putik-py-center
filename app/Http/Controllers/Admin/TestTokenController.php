<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestTokenBatch;
use App\Models\TestToken;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TestTokenController extends Controller
{
    public function index()
    {
        $batches = TestTokenBatch::withCount('tokens')
            ->latest()
            ->get();

        return Inertia::render('admin/bank-soal/Index', [
            'batches' => $batches
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/bank-soal/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|in:minat-bakat,intelegensi,gaya-belajar',
            'total_tokens' => 'required|integer|min:1|max:1000',
            'expired_at' => 'required|date|after_or_equal:today',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $batch = TestTokenBatch::create($validated);

            $tokens = [];

            for ($i = 0; $i < $validated['total_tokens']; $i++) {
                $tokens[] = [
                    'batch_id' => $batch->id,
                    'token' => strtoupper(Str::random(10)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TestToken::insert($tokens);

            DB::commit();

            return redirect()
                ->route('bankSoal')
                ->with('success', 'Token berhasil dibuat!');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal generate token. Silakan coba lagi.');
        }
    }

    public function show(TestTokenBatch $batch)
    {
        $batch->load(['tokens' => fn ($query) => $query->orderBy('id')]);

        return Inertia::render('admin/bank-soal/Detail', [
            'batch' => $batch
        ]);
    }

    public function exportExcel(TestTokenBatch $batch): BinaryFileResponse
    {
        $batch->load(['tokens' => fn ($query) => $query->orderBy('id')]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Token Batch');
        $sheet->fromArray([
            'Batch ID',
            'Jenis Tes',
            'Token',
            'Status',
            'Digunakan Pada',
            'Masa Berlaku',
            'Tanggal Dibuat Batch',
            'Catatan',
        ], null, 'A1');

        $row = 2;
        foreach ($batch->tokens as $token) {
            $sheet->fromArray([
                $batch->id,
                $this->testTypeLabel($batch->test_type),
                $token->token,
                $token->is_used ? 'Terpakai' : 'Tersedia',
                optional($token->used_at)?->format('d-m-Y H:i:s') ?? '-',
                optional($batch->expired_at)?->format('d-m-Y') ?? '-',
                optional($batch->created_at)?->format('d-m-Y H:i:s') ?? '-',
                $batch->note ?: '-',
            ], null, 'A' . $row);

            $row++;
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $safeType = str_replace(' ', '-', strtolower($this->testTypeLabel($batch->test_type)));
        $fileName = "token-batch-{$batch->id}-{$safeType}.xlsx";

        $tempFile = tempnam(sys_get_temp_dir(), 'token-batch-');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function exportPdf(TestTokenBatch $batch)
    {
        $batch->load(['tokens' => fn ($query) => $query->orderBy('id')]);

        $safeType = str_replace(' ', '-', strtolower($this->testTypeLabel($batch->test_type)));
        $fileName = "token-batch-{$batch->id}-{$safeType}.pdf";

        $pdf = Pdf::loadView('pdf.token-batch', [
            'batch' => $batch,
            'testTypeLabel' => $this->testTypeLabel($batch->test_type),
        ])->setPaper('a4', 'portrait');

        return $pdf->download($fileName);
    }

    public function edit(TestTokenBatch $batch)
    {
        return Inertia::render('admin/bank-soal/Edit', [
            'batch' => $batch
        ]);
    }

    public function update(Request $request, TestTokenBatch $batch)
    {
        $validated = $request->validate([
            'test_type' => 'required|string|in:minat-bakat,intelegensi,gaya-belajar',
            'expired_at' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            $batch->update($validated);

            return redirect()
                ->route('bankSoal')
                ->with('info', 'Batch token berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui batch.');
        }
    }

    public function destroy(TestTokenBatch $batch)
    {
        try {
            $batch->delete();

            return redirect()
                ->route('bankSoal')
                ->with('success', 'Batch token berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus batch.');
        }
    }

    private function testTypeLabel(string $testType): string
    {
        return match ($testType) {
            'minat-bakat' => 'Tes Minat Bakat',
            'intelegensi' => 'Tes Intelegensi',
            'gaya-belajar' => 'Tes Gaya Belajar',
            default => $testType,
        };
    }
}