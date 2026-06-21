<?php

namespace App\Livewire;

use Livewire\Component;

class Export extends Component
{
    public string $format = 'csv';

    public string $type = 'all'; // all, income, expense

    public string $period = 'this_month'; // this_month, last_month, this_year, all

    private function getFilteredTransactions()
    {
        $user = auth()->user();
        $q = $user->transactions()->with(['wallet', 'category'])->orderBy('date', 'desc');

        // Type filter
        if ($this->type !== 'all') {
            $q->where('type', $this->type);
        }

        // Period filter
        switch ($this->period) {
            case 'this_month':
                $q->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
                break;
            case 'last_month':
                $q->whereMonth('date', now()->subMonth()->month)
                    ->whereYear('date', now()->subMonth()->year);
                break;
            case 'this_year':
                $q->whereYear('date', now()->year);
                break;
                // 'all' = no filter
        }

        return $q->get();
    }

    public function download()
    {
        if (! auth()->user()->isPro()) {
            session()->flash('error', 'Ekspor hanya untuk akun Pro.');

            return;
        }

        $txns = $this->getFilteredTransactions();
        $user = auth()->user();
        $periodLabel = match ($this->period) {
            'this_month' => now()->locale('id')->isoFormat('MMMM Y'),
            'last_month' => now()->subMonth()->locale('id')->isoFormat('MMMM Y'),
            'this_year' => now()->year,
            'all' => 'Semua Waktu',
        };

        $rows = $txns->map(fn ($t) => [
            'Tanggal' => $t->date->format('d/m/Y'),
            'Jenis' => $t->type === 'income' ? 'Pemasukan' : ($t->type === 'expense' ? 'Pengeluaran' : 'Transfer'),
            'Deskripsi' => $t->description ?? '-',
            'Kategori' => $t->category->name ?? '-',
            'Dompet' => $t->wallet->name ?? '-',
            'Jumlah' => $t->type === 'expense' ? -$t->amount : $t->amount,
        ]);

        $filename = 'FamiBalance_'.$this->type.'_'.str_replace(' ', '_', $periodLabel);

        switch ($this->format) {
            case 'csv':
                return $this->downloadCsv($rows, $filename);
            case 'excel':
                return $this->downloadExcel($rows, $filename);
            case 'pdf':
                return $this->downloadPdf($rows, $txns, $user, $periodLabel, $filename);
        }
    }

    private function downloadCsv($rows, $filename)
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}.csv\""];

        return response()->stream(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, array_keys($rows->first() ?? []));
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }

    private function downloadExcel($rows, $filename)
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}.xls\"",
        ];

        return response()->stream(function () use ($rows) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head><meta charset="UTF-8">';
            echo '<style>td,th{border:1px solid #ccc;padding:6px 10px;font-size:12px}th{background:#7C3AED;color:#fff;font-weight:600}</style>';
            echo '</head><body><table>';
            echo '<tr><th>Tanggal</th><th>Jenis</th><th>Deskripsi</th><th>Kategori</th><th>Dompet</th><th>Jumlah</th></tr>';
            foreach ($rows as $row) {
                $amt = $row['Jumlah'];
                $color = $amt >= 0 ? '#059669' : '#DC2626';
                echo '<tr>';
                echo '<td>'.$row['Tanggal'].'</td>';
                echo '<td>'.$row['Jenis'].'</td>';
                echo '<td>'.$row['Deskripsi'].'</td>';
                echo '<td>'.$row['Kategori'].'</td>';
                echo '<td>'.$row['Dompet'].'</td>';
                echo '<td style="color:'.$color.'">'.number_format($amt, 0, ',', '.').'</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
        }, 200, $headers);
    }

    private function downloadPdf($rows, $txns, $user, $periodLabel, $filename)
    {
        // Render a print-friendly HTML page; user can Save As PDF from browser
        $html = view('livewire.export-print', [
            'rows' => $rows,
            'user' => $user,
            'periodLabel' => $periodLabel,
            'totalIncome' => $txns->where('type', 'income')->sum('amount'),
            'totalExpense' => $txns->where('type', 'expense')->sum('amount'),
        ])->render();

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "inline; filename=\"{$filename}.html\"");
    }

    public function render()
    {
        $user = auth()->user();
        $txCount = $user->transactions()->count();

        return view('livewire.export', [
            'txnCount' => $txCount,
        ])->layout('layouts.app');
    }
}
