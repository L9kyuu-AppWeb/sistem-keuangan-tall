@php
    $budgetPercent = $generalAmount > 0 ? min(100, round(($totalExpense / $generalAmount) * 100)) : 0;
    $remaining = $generalAmount - $totalExpense;
    $monthName = now()->locale('id')->isoFormat('MMMM Y');
@endphp
<div class="page active" style="min-height:780px">
    {{-- Topbar --}}
    <div class="topbar">
        <a href="{{ route('dashboard') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;gap:4px">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h1>Anggaran Bulanan</h1>
        <p>Atur batas pengeluaran per kategori</p>
    </div>

    {{-- Scroll area --}}
    <div class="scroll-area" style="padding-top:16px">
        {{-- Flash messages --}}
        @if (session('success'))
            <div class="tip" style="background:#ECFDF5;border-color:#A7F3D0;color:#065F46;margin-bottom:12px">
                <i class="ti ti-check-circle" style="color:#059669"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="tip" style="background:#FEF2F2;border-color:#FECACA;color:#991B1B;margin-bottom:12px">
                <i class="ti ti-alert-circle" style="color:#EF4444"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Hero summary: Budget Overview --}}
        <div class="card card-brand" style="margin-top:0">
            <p style="font-size:13px;opacity:.8">Ringkasan Anggaran {{ $monthName }}</p>
            <p style="font-size:30px;font-weight:700;margin:4px 0;color:#fff">Rp {{ number_format($generalAmount, 0, ',', '.') }}</p>
            <div style="display:flex;gap:12px;margin-top:10px">
                <div style="flex:1;background:rgba(255,255,255,.15);border-radius:8px;padding:8px">
                    <p style="font-size:11px;opacity:.75;color:#fff">Terpakai</p>
                    <p style="font-size:15px;font-weight:600;color:#fff">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div style="flex:1;background:rgba(255,255,255,.15);border-radius:8px;padding:8px">
                    <p style="font-size:11px;opacity:.75;color:#fff">Sisa</p>
                    <p style="font-size:15px;font-weight:600;color:#fff">Rp {{ number_format(max(0, $remaining), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- General Budget Card --}}
        <div class="card">
            @if ($editing)
                <p class="sec-title" style="margin-bottom:16px">Edit Anggaran</p>
                <div class="form-group">
                    <label class="form-label">Total Anggaran</label>
                    <div style="position:relative">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#888;font-size:15px">Rp</span>
                        <input type="number" wire:model="generalAmount"
                               class="form-input" style="padding-left:36px;font-size:20px;font-weight:600"
                               placeholder="0">
                    </div>
                </div>

                @if (auth()->user()->isPro())
                    <p class="sec-title" style="font-size:14px;margin-bottom:12px;margin-top:8px">
                        <i class="ti ti-chart-pie" style="color:var(--brand);margin-right:4px"></i>
                        Budget per Kategori
                    </p>
                    @foreach (\App\Models\Category::all() as $cat)
                        <div class="cat-row" style="margin-bottom:6px">
                            <div class="cat-icon">
                                <i class="ti ti-{{ $cat->icon }}"></i>
                            </div>
                            <div class="cat-info">
                                <div class="cat-name">{{ $cat->name }}</div>
                            </div>
                            <div style="position:relative;width:110px">
                                <span style="position:absolute;left:8px;top:50%;transform:translateY(-50%);color:#888;font-size:11px">Rp</span>
                                <input type="number" wire:model="categoryAmounts.{{ $cat->id }}"
                                       class="form-input" style="padding:8px 8px 8px 24px;font-size:12px;width:100%"
                                       placeholder="0">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="lock-overlay" style="margin-top:8px">
                        <div class="blur-content" style="padding:8px">
                            <div class="cat-row"><div class="cat-icon"><i class="ti ti-shopping-cart"></i></div><div class="cat-info"><div class="cat-name">Belanja</div></div><div style="width:110px;height:32px;background:#eee;border-radius:8px"></div></div>
                            <div class="cat-row"><div class="cat-icon"><i class="ti ti-bolt"></i></div><div class="cat-info"><div class="cat-name">Tagihan</div></div><div style="width:110px;height:32px;background:#eee;border-radius:8px"></div></div>
                        </div>
                        <div class="lock-badge">
                            <i class="ti ti-crown"></i>
                            <p>Budget per Kategori untuk Pro</p>
                            <a href="{{ route('paywall') }}" class="btn btn-primary" style="width:auto;padding:10px 20px;font-size:13px;text-decoration:none">Upgrade Pro</a>
                        </div>
                    </div>
                @endif

                <div style="display:flex;gap:8px;margin-top:16px">
                    <button wire:click="$set('editing', false)" class="btn btn-gray" style="flex:1;padding:12px">Batal</button>
                    <button wire:click="save" class="btn btn-primary" style="flex:1;padding:12px">Simpan</button>
                </div>
            @else
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                    <p class="sec-title" style="margin:0">Anggaran Umum</p>
                    <button wire:click="$set('editing', true)" style="background:none;border:none;color:var(--brand);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:4px">
                        <i class="ti ti-edit" style="font-size:14px"></i> Edit
                    </button>
                </div>
                <div class="prog-wrap">
                    <div class="prog-label">
                        <span>Total Pengeluaran</span>
                        <span style="color:#555;font-weight:500">Rp {{ number_format($totalExpense, 0, ',', '.') }} / Rp {{ number_format($generalAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="prog-bar">
                        <div class="prog-fill" style="width:{{ $budgetPercent }}%"></div>
                    </div>
                </div>
                <p style="font-size:12px;color:#888;margin-top:4px">
                    Sisa anggaran: <b style="color:var(--brand)">Rp {{ number_format(max(0, $remaining), 0, ',', '.') }}</b>
                </p>
            @endif
        </div>

        {{-- Per-Category Budget Display --}}
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                <p class="sec-title" style="margin:0">Anggaran per Kategori</p>
                <div style="display:flex;align-items:center;gap:6px">
                    @if (!auth()->user()->isPro())
                        <span class="badge badge-free">Pro</span>
                    @endif
                    <a href="{{ route('categories') }}" style="color:var(--brand);font-size:16px;text-decoration:none" title="Atur Kategori">
                        <i class="ti ti-settings"></i>
                    </a>
                </div>
            </div>

            @if (!auth()->user()->isPro())
                <div style="text-align:center;padding:24px 16px;border:1.5px dashed #DDD6FE;border-radius:12px">
                    <i class="ti ti-lock" style="font-size:36px;color:var(--brand)"></i>
                    <p style="font-size:15px;font-weight:600;color:#5B21B6;margin-top:10px">Atur Budget per Kategori</p>
                    <p style="font-size:13px;color:#888;margin-top:6px;line-height:1.6">Pisahkan budget untuk makan, tagihan, belanja, dan lainnya.</p>
                    <a href="{{ route('paywall') }}" class="btn btn-primary" style="margin-top:16px;padding:12px;font-size:14px;width:auto;display:inline-flex;text-decoration:none">
                        <i class="ti ti-crown"></i> Upgrade ke Pro
                    </a>
                </div>
            @else
                <div>
                    @foreach ($categorySpending as $data)
                        @php
                            $pct = $data['percent'];
                            $barColor = $pct >= 90 ? '#EF4444' : ($pct >= 70 ? '#F59E0B' : '#970747');
                            $barBg = $pct >= 90 ? '#FEF2F2' : ($pct >= 70 ? '#FFFBEB' : '#F0EBFF');
                        @endphp
                        <div class="txn">
                            <div class="txn-icon budget">
                                <i class="ti ti-{{ $data['category']->icon }}"></i>
                            </div>
                            <div class="txn-body">
                                <p>{{ $data['category']->name }}</p>
                                <span>
                                    @if ($data['budget'] > 0)
                                        Rp {{ number_format($data['spent'], 0, ',', '.') }} dari Rp {{ number_format($data['budget'], 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($data['spent'], 0, ',', '.') }} (belum ada budget)
                                    @endif
                                </span>
                            </div>
                            <div class="txn-amt" style="color:{{ $barColor }};font-size:12px">
                                @if ($data['budget'] > 0)
                                    {{ $pct }}%
                                @endif
                            </div>
                        </div>
                        @if ($data['budget'] > 0)
                            <div class="prog-bar" style="height:5px;margin:0 0 8px 50px;background:{{ $barBg }}">
                                <div class="prog-fill" style="width:{{ $pct }}%;background:{{ $barColor }};height:5px"></div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Tips --}}
                <div class="tip" style="margin-top:12px;margin-bottom:0">
                    <i class="ti ti-bulb"></i>
                    <span><b>Tips:</b> Tekan tombol Edit di Anggaran Umum untuk menyesuaikan budget bulan ini kapan saja.</span>
                </div>
            @endif
        </div>
    </div>
</div>
