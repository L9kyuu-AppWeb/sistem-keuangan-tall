<div class="page active" style="min-height:780px">
    <div class="topbar">
        <a href="{{ route('profile') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;gap:4px">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h1>Ekspor Data</h1>
        <p>Download transaksi dalam berbagai format</p>
    </div>

    <div class="scroll-area" style="padding-top:16px">
        @if (session('error'))
            <div class="tip" style="background:#FEF2F2;border-color:#FECACA;color:#991B1B;margin-bottom:12px">
                <i class="ti ti-alert-circle" style="color:#EF4444"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (!auth()->user()->isPro())
            <div class="card" style="position:relative;overflow:hidden;min-height:280px">
                <div style="padding:8px">
                    <div style="height:14px;background:#DDD6FE;border-radius:6px;width:60%;margin-bottom:10px"></div>
                    <div style="height:44px;background:#DDD6FE;border-radius:10px;margin-bottom:8px"></div>
                    <div style="height:44px;background:#DDD6FE;border-radius:10px;margin-bottom:8px"></div>
                    <div style="height:44px;background:#DDD6FE;border-radius:10px"></div>
                </div>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(255,255,255,.8);gap:10px;padding:20px">
                    <div style="width:52px;height:52px;background:#F0EBFF;border-radius:14px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-crown" style="font-size:26px;color:var(--brand)"></i>
                    </div>
                    <p style="font-size:15px;font-weight:600;color:#1a1a1a;text-align:center">Fitur Pro</p>
                    <p style="font-size:12px;color:#888;text-align:center;line-height:1.5;padding:0 16px">
                        Ekspor transaksi ke Excel, CSV & PDF hanya tersedia untuk akun Pro.
                    </p>
                    <a href="{{ route('paywall') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;border-radius:12px;padding:12px 28px;font-size:14px;font-weight:600;text-decoration:none;margin-top:4px;box-shadow:0 4px 12px rgba(151,7,71,.3)">
                        <i class="ti ti-crown" style="font-size:16px"></i> Upgrade ke Pro
                    </a>
                </div>
            </div>
        @else
            {{-- Period filter --}}
            <div class="card">
                <p class="sec-title" style="margin-bottom:10px">
                    <i class="ti ti-calendar" style="color:var(--brand);margin-right:4px"></i>
                    Periode Data
                </p>
                <div style="display:flex;flex-wrap:wrap;gap:6px">
                    @php
                        $periods = [
                            'this_month' => 'Bulan Ini',
                            'last_month' => 'Bulan Lalu',
                            'this_year'  => 'Tahun Ini',
                            'all'        => 'Semua',
                        ];
                    @endphp
                    @foreach ($periods as $val => $label)
                        <button wire:click="$set('period', '{{ $val }}')"
                                style="padding:8px 14px;border-radius:20px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid {{ $period === $val ? 'var(--brand)' : '#e5e5e5' }};background:{{ $period === $val ? 'var(--brand)' : '#fff' }};color:{{ $period === $val ? '#fff' : '#555' }};transition:all .15s">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Type filter --}}
            <div class="card">
                <p class="sec-title" style="margin-bottom:10px">
                    <i class="ti ti-filter" style="color:var(--brand);margin-right:4px"></i>
                    Jenis Transaksi
                </p>
                <div style="display:flex;gap:6px">
                    @php
                        $types = [
                            'all'     => ['label' => 'Semua', 'icon' => 'list'],
                            'income'  => ['label' => 'Pemasukan', 'icon' => 'arrow-down-circle'],
                            'expense' => ['label' => 'Pengeluaran', 'icon' => 'shopping-cart'],
                        ];
                    @endphp
                    @foreach ($types as $val => $info)
                        <button wire:click="$set('type', '{{ $val }}')"
                                style="flex:1;padding:10px;border-radius:12px;font-size:12px;font-weight:600;cursor:pointer;border:1.5px solid {{ $type === $val ? 'var(--brand)' : '#e5e5e5' }};background:{{ $type === $val ? 'var(--brand)' : '#fff' }};color:{{ $type === $val ? '#fff' : '#555' }};display:flex;align-items:center;justify-content:center;gap:4px;transition:all .15s">
                            <i class="ti ti-{{ $info['icon'] }}"></i> {{ $info['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Download buttons --}}
            <div class="card">
                <p class="sec-title" style="margin-bottom:10px">
                    <i class="ti ti-download" style="color:var(--brand);margin-right:4px"></i>
                    Format Download
                </p>

                <button wire:click="download" style="display:flex;align-items:center;gap:12px;width:100%;padding:14px;border:1.5px solid #e5e5e5;border-radius:12px;background:#fff;cursor:pointer;margin-bottom:8px;transition:all .15s" onmouseover="this.style.borderColor='var(--brand)'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <div style="width:40px;height:40px;background:#ECFDF5;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-file-spreadsheet" style="font-size:20px;color:#059669"></i>
                    </div>
                    <div style="text-align:left">
                        <p style="font-size:14px;font-weight:600;color:#1a1a1a">CSV</p>
                        <p style="font-size:11px;color:#888">Ringan, universal — Excel, Google Sheets</p>
                    </div>
                </button>

                <button wire:click="$set('format', 'excel'); $dispatch('download')" wire:click="download" style="display:flex;align-items:center;gap:12px;width:100%;padding:14px;border:1.5px solid #e5e5e5;border-radius:12px;background:#fff;cursor:pointer;margin-bottom:8px;transition:all .15s" onmouseover="this.style.borderColor='var(--brand)'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <div style="width:40px;height:40px;background:#F0F7FF;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-table" style="font-size:20px;color:#2563EB"></i>
                    </div>
                    <div style="text-align:left">
                        <p style="font-size:14px;font-weight:600;color:#1a1a1a">Excel (.xls)</p>
                        <p style="font-size:11px;color:#888">Format tabel rapi untuk Microsoft Excel</p>
                    </div>
                </button>

                <button wire:click="download" style="display:flex;align-items:center;gap:12px;width:100%;padding:14px;border:1.5px solid #e5e5e5;border-radius:12px;background:#fff;cursor:pointer;transition:all .15s" onmouseover="this.style.borderColor='var(--brand)'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <div style="width:40px;height:40px;background:#FEF2F2;border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-file-text" style="font-size:20px;color:#DC2626"></i>
                    </div>
                    <div style="text-align:left">
                        <p style="font-size:14px;font-weight:600;color:#1a1a1a">PDF</p>
                        <p style="font-size:11px;color:#888">Cetak / simpan sebagai PDF dari browser</p>
                    </div>
                </button>
            </div>

            <div class="card">
                <div style="display:flex;align-items:center;gap:10px">
                    <i class="ti ti-info-circle" style="color:var(--brand);font-size:18px;flex-shrink:0"></i>
                    <p style="font-size:12px;color:#888;line-height:1.5">
                        Data yang diunduh difilter berdasarkan periode dan jenis transaksi yang dipilih.
                        Total: <b style="color:#1a1a1a">{{ $txnCount }}</b> transaksi tercatat.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
