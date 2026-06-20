<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - FamiBalance</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; padding:40px; color:#1a1a1a; }
        h1 { font-size:24px; margin-bottom:4px; }
        .sub { color:#888; font-size:13px; margin-bottom:24px; }
        .summary { display:flex; gap:16px; margin-bottom:28px; }
        .summary > div { flex:1; padding:16px; border-radius:12px; }
        .income { background:#ECFDF5; }
        .expense { background:#FEF2F2; }
        .summary label { font-size:11px; display:block; margin-bottom:4px; text-transform:uppercase; }
        .summary .val { font-size:22px; font-weight:700; }
        table { width:100%; border-collapse:collapse; margin-top:12px; }
        th { background:#7C3AED; color:#fff; padding:10px 12px; font-size:12px; text-align:left; }
        td { padding:8px 12px; font-size:12px; border-bottom:1px solid #eee; }
        tr:last-child td { border-bottom:none; }
        .foot { margin-top:24px; font-size:11px; color:#aaa; text-align:center; }
        @media print {
            body { padding:20px; }
            .summary > div { break-inside:avoid; }
        }
    </style>
</head>
<body>
    <h1>Laporan Keuangan</h1>
    <p class="sub">{{ $user->name }} · {{ $periodLabel }}</p>

    <div class="summary">
        <div class="income">
            <label>Total Pemasukan</label>
            <div class="val" style="color:#059669">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>
        <div class="expense">
            <label>Total Pengeluaran</label>
            <div class="val" style="color:#DC2626">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Dompet</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row['Tanggal'] }}</td>
                    <td>
                        <span style="padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;background:{{ $row['Jenis'] === 'Pemasukan' ? '#ECFDF5' : ($row['Jenis'] === 'Pengeluaran' ? '#FEF2F2' : '#EFF6FF') }};color:{{ $row['Jenis'] === 'Pemasukan' ? '#059669' : ($row['Jenis'] === 'Pengeluaran' ? '#DC2626' : '#2563EB') }}">
                            {{ $row['Jenis'] }}
                        </span>
                    </td>
                    <td>{{ $row['Deskripsi'] }}</td>
                    <td>{{ $row['Kategori'] }}</td>
                    <td>{{ $row['Dompet'] }}</td>
                    <td style="font-weight:600;color:{{ $row['Jumlah'] >= 0 ? '#059669' : '#DC2626' }}">{{ $row['Jumlah'] >= 0 ? '+' : '' }}{{ number_format($row['Jumlah'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="foot">Dibuat oleh FamiBalance · {{ now()->locale('id')->isoFormat('D MMMM Y HH:mm') }}</p>
</body>
</html>
