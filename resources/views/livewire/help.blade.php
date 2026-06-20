<div class="page active" style="min-height:780px">
    <div class="topbar">
        <a href="{{ route('profile') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;gap:4px">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h1>Pusat Bantuan</h1>
    </div>

    <div class="scroll-area" style="padding-top:16px">
        {{-- FAQ --}}
        <div class="card">
            <p class="sec-title">
                <i class="ti ti-help-circle" style="color:var(--brand);margin-right:6px"></i>
                Pertanyaan Umum
            </p>

            @php
                $faqs = [
                    ['q' => 'Bagaimana cara menambah transaksi?', 'a' => 'Ketuk tombol "+" di bagian bawah layar pada tab Beranda. Pilih jenis (Pemasukan/Pengeluaran/Transfer), isi nominal, deskripsi, pilih dompet & kategori.'],
                    ['q' => 'Bagaimana cara membuat dompet baru?', 'a' => 'Buka tab Dompet, ketuk "Tambah Dompet". Free user bisa membuat hingga 2 dompet, Pro unlimited.'],
                    ['q' => 'Apa itu Anggaran Bulanan?', 'a' => 'Anggaran membantu membatasi pengeluaran tiap bulan. Atur total anggaran di tab Beranda → "Atur Anggaran". Fitur per kategori tersedia untuk Pro.'],
                    ['q' => 'Bagaimana cara transfer antar dompet?', 'a' => 'Di form transaksi, pilih jenis "Transfer". Pilih dompet asal dan dompet tujuan, masukkan nominal. Saldo akan terpotong dari asal dan bertambah di tujuan.'],
                    ['q' => 'Apa beda akun Free dan Pro?', 'a' => 'Free: 2 dompet, anggaran bulanan, kategori default. Pro: unlimited dompet, kategori kustom, budget per kategori, family sync, ekspor Excel/CSV/PDF.'],
                    ['q' => 'Bagaimana cara melihat riwayat transaksi?', 'a' => 'Buka tab Transaksi untuk melihat semua riwayat. Gunakan filter untuk mencari berdasarkan periode, kategori, atau dompet.'],
                ];
            @endphp

            @foreach ($faqs as $i => $faq)
                <div class="txn" style="cursor:default;padding:12px 0">
                    <div style="width:28px;height:28px;background:var(--brand-light);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <span style="font-size:12px;font-weight:700;color:var(--brand)">{{ $i + 1 }}</span>
                    </div>
                    <div class="txn-body">
                        <p style="font-weight:600">{{ $faq['q'] }}</p>
                        <span style="font-size:12px;line-height:1.5">{{ $faq['a'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Contact --}}
        <div class="card">
            <p class="sec-title">
                <i class="ti ti-mail" style="color:var(--brand);margin-right:6px"></i>
                Hubungi Kami
            </p>

            <div class="txn" style="padding:10px 0">
                <div class="txn-icon in" style="width:36px;height:36px">
                    <i class="ti ti-mail"></i>
                </div>
                <div class="txn-body">
                    <p style="font-weight:500">Email Dukungan</p>
                    <span>support@famibalance.com</span>
                </div>
            </div>

            <div class="txn" style="padding:10px 0">
                <div class="txn-icon in" style="width:36px;height:36px">
                    <i class="ti ti-world"></i>
                </div>
                <div class="txn-body">
                    <p style="font-weight:500">Website</p>
                    <span>www.famibalance.com</span>
                </div>
            </div>
        </div>

        {{-- About --}}
        <div class="card" style="text-align:center;padding:20px">
            <div style="width:48px;height:48px;background:var(--brand);border-radius:14px;display:inline-flex;align-items:center;justify-content:center">
                <i class="ti ti-wallet" style="font-size:24px;color:#fff"></i>
            </div>
            <p style="font-size:16px;font-weight:600;margin-top:8px">FamiBalance</p>
            <p style="font-size:12px;color:#888">Versi 1.0.0</p>
            <p style="font-size:11px;color:#aaa;margin-top:6px">© {{ now()->year }} FamiBalance. All rights reserved.</p>
        </div>
    </div>
</div>
