<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Token Batch</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            margin-bottom: 18px;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .meta td {
            padding: 4px 6px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .meta td.label {
            width: 180px;
            background: #f3f4f6;
            font-weight: 600;
        }

        table.tokens {
            width: 100%;
            border-collapse: collapse;
        }

        table.tokens th,
        table.tokens td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            text-align: left;
            word-break: break-word;
        }

        table.tokens th {
            background: #f9fafb;
            font-weight: 700;
        }

        .footer {
            margin-top: 10px;
            color: #6b7280;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="title">Daftar Token Bank Soal</div>
    <div>Batch ID: {{ $batch->id }}</div>
</div>

<table class="meta">
    <tr>
        <td class="label">Jenis Tes</td>
        <td>{{ $testTypeLabel }}</td>
    </tr>
    <tr>
        <td class="label">Jumlah Token</td>
        <td>{{ $batch->total_tokens }}</td>
    </tr>
    <tr>
        <td class="label">Token Tersedia</td>
        <td>{{ $batch->tokens->where('is_used', false)->count() }}</td>
    </tr>
    <tr>
        <td class="label">Masa Berlaku</td>
        <td>{{ optional($batch->expired_at)->format('d-m-Y') ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Tanggal Dibuat</td>
        <td>{{ optional($batch->created_at)->format('d-m-Y H:i:s') ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Catatan</td>
        <td>{{ $batch->note ?: '-' }}</td>
    </tr>
</table>

<table class="tokens">
    <thead>
    <tr>
        <th style="width: 45px;">No</th>
        <th style="width: 160px;">Token</th>
        <th style="width: 90px;">Status</th>
        <th>Digunakan Pada</th>
    </tr>
    </thead>
    <tbody>
    @forelse($batch->tokens as $index => $token)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $token->token }}</td>
            <td>{{ $token->is_used ? 'Terpakai' : 'Tersedia' }}</td>
            <td>{{ optional($token->used_at)->format('d-m-Y H:i:s') ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align: center;">Tidak ada token untuk batch ini.</td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="footer">
    Diekspor pada {{ now()->timezone(config('app.timezone'))->format('d-m-Y H:i:s') }}
</div>
</body>
</html>
