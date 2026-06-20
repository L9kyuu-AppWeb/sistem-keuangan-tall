<div class="page active" style="min-height:780px">
    {{-- HERO --}}
    <div style="background:#970747;padding:32px 24px 24px;color:#fff;text-align:center">
        <a href="{{ route('profile') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;display:flex;align-items:center;gap:4px;margin:0 auto 20px;text-decoration:none">
            <i class="ti ti-x"></i> Tutup
        </a>
        <i class="ti ti-crown" style="font-size:40px;color:#FCD34D"></i>
        <h2 style="font-size:24px;font-weight:700;margin:8px 0 4px">FamiBalance Pro</h2>
        <p style="font-size:14px;opacity:.85">Kelola keuangan keluarga tanpa batas</p>

        {{-- PLAN SELECTOR --}}
        <div style="display:flex;gap:8px;margin-top:16px;justify-content:center">
            <div wire:click="selectPlan('monthly')"
                style="flex:1;max-width:140px;border:2px solid {{ $selectedPlan === 'monthly' ? '#fff' : 'rgba(255,255,255,.3)' }};border-radius:12px;padding:12px;cursor:pointer;text-align:center;background:{{ $selectedPlan === 'monthly' ? 'rgba(255,255,255,.2)' : 'rgba(255,255,255,.08)' }}">
                <div style="font-size:11px;opacity:.8;color:#fff">Bulanan</div>
                <div style="font-size:20px;font-weight:700;color:#fff">Rp 29rb</div>
                <div style="font-size:10px;opacity:.7;color:#fff">/bulan</div>
            </div>
            <div wire:click="selectPlan('yearly')"
                style="flex:1;max-width:140px;border:2px solid {{ $selectedPlan === 'yearly' ? '#fff' : 'rgba(255,255,255,.3)' }};border-radius:12px;padding:12px;cursor:pointer;text-align:center;background:{{ $selectedPlan === 'yearly' ? 'rgba(255,255,255,.2)' : 'rgba(255,255,255,.08)' }};position:relative">
                <div style="position:absolute;top:-10px;left:50%;transform:translateX(-50%);background:#FCD34D;color:#92400E;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;white-space:nowrap">HEMAT 30%</div>
                <div style="font-size:11px;opacity:.8;color:#fff">Tahunan</div>
                <div style="font-size:20px;font-weight:700;color:#fff">Rp 249rb</div>
                <div style="font-size:10px;opacity:.7;color:#fff">/tahun</div>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div style="margin:12px 16px 0;background:#ECFDF5;border:1px solid #A7F3D0;border-radius:10px;padding:12px;font-size:13px;color:#065F46;display:flex;gap:8px;align-items:center">
            <i class="ti ti-check-circle" style="font-size:18px;color:#059669;flex-shrink:0"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="margin:12px 16px 0;background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:12px;font-size:13px;color:#991B1B;display:flex;gap:8px;align-items:center">
            <i class="ti ti-alert-circle" style="font-size:18px;color:#EF4444;flex-shrink:0"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ACTIVE STATUS --}}
    @if ($activeSub && $activeSub->isActive())
        <div style="margin:12px 16px;background:#F0FDF4;border:1.5px solid #86EFAC;border-radius:12px;padding:14px;text-align:center">
            <i class="ti ti-check-circle" style="font-size:24px;color:#16A34A"></i>
            <p style="font-size:14px;font-weight:600;color:#166534;margin-top:6px">Akun Pro Aktif</p>
            @if ($activeSub->status === 'trial')
                <p style="font-size:12px;color:#666;margin-top:2px">Masa percobaan berakhir {{ $activeSub->trial_ends_at->isoFormat('D MMM YYYY') }}</p>
            @else
                <p style="font-size:12px;color:#666;margin-top:2px">Berlaku hingga {{ $activeSub->ends_at->isoFormat('D MMM YYYY') }}</p>
            @endif
        </div>
    @endif

    {{-- FEATURE LIST --}}
    <div class="scroll-area" style="padding-top:16px">
        <p style="font-size:16px;font-weight:600;color:#1a1a1a;margin:0 0 12px">Yang Anda dapatkan</p>

        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-wallet" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Dompet Virtual Tak Terbatas</p><span style="font-size:12px;color:#888">Tambah rekening, e-wallet, kas sebanyak yang Anda mau</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-star" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Harga Emas Real-Time & Analisis</p><span style="font-size:12px;color:#888">Grafik gain/loss otomatis setiap hari</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-users" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Family Sync — Bagi Buku Berdua</p><span style="font-size:12px;color:#888">Satu buku kas, dua perangkat, sinkron real-time</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-chart-pie" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Multi-Anggaran per Kategori</p><span style="font-size:12px;color:#888">Budget terpisah untuk makan, tagihan, hiburan, dll.</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-tag" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Kategori Kustom Tak Terbatas</p><span style="font-size:12px;color:#888">Buat dan kelola kategori sesuai kebutuhan keluarga</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-download" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">Ekspor Excel, CSV & PDF</p><span style="font-size:12px;color:#888">Laporan keuangan tahunan untuk perencanaan</span></div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:0.5px solid #f0f0f0">
            <i class="ti ti-ad-off" style="font-size:20px;color:#970747;flex-shrink:0;margin-top:2px"></i>
            <div><p style="font-size:14px;font-weight:500;color:#1a1a1a">100% Bebas Iklan</p><span style="font-size:12px;color:#888">Pengalaman bersih tanpa gangguan</span></div>
        </div>

        {{-- 7 DAY FREE TRIAL --}}
        @if (!$hasTrial && !$activeSub?->isActive())
            <button wire:click="startTrial"
                style="width:100%;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#970747;color:#fff;margin-top:16px;display:flex;align-items:center;justify-content:center;gap:8px">
                <i class="ti ti-gift"></i> Mulai 7 Hari Gratis
            </button>
            <p style="text-align:center;font-size:12px;color:#888;margin-top:8px">Kartu kredit tidak diperlukan. Batalkan kapan saja.</p>
        @endif

        {{-- PAYMENT BUTTON --}}
        @if ($activeSub && $activeSub->status === 'trial')
            <button wire:click="pay" wire:loading.attr="disabled"
                style="width:100%;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#970747;color:#fff;margin-top:16px;display:flex;align-items:center;justify-content:center;gap:8px">
                <i class="ti ti-crown"></i> {{ $selectedPlan === 'monthly' ? 'Bayar Rp 29.000/bulan' : 'Bayar Rp 249.000/tahun' }}
            </button>
            <p style="text-align:center;font-size:12px;color:#888;margin-top:8px">Pembayaran aman via Midtrans</p>
        @endif

        @if (!$hasTrial && (!$activeSub || !$activeSub->isActive()))
            <button wire:click="pay" wire:loading.attr="disabled"
                style="width:100%;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#970747;color:#fff;margin-top:16px;display:flex;align-items:center;justify-content:center;gap:8px">
                <i class="ti ti-crown"></i> {{ $selectedPlan === 'monthly' ? 'Bayar Rp 29.000/bulan' : 'Bayar Rp 249.000/tahun' }}
            </button>
            <p style="text-align:center;font-size:12px;color:#888;margin-top:8px">Pembayaran aman via Midtrans</p>
        @endif

        {{-- SECURITY NOTE --}}
        <div style="margin-top:16px;padding:12px;background:#F8F5FF;border-radius:10px;display:flex;gap:8px">
            <i class="ti ti-shield-check" style="color:#970747;font-size:20px;flex-shrink:0;margin-top:2px"></i>
            <p style="font-size:12px;color:#5B21B6">FamiBalance adalah aplikasi pencatatan saja. Pembayaran berlangganan diproses aman oleh Midtrans. Kami tidak menyimpan data rekening Anda.</p>
        </div>
    </div>
</div>

@script
<script>
    Livewire.on('openMidtransPayment', (data) => {
        window.snap.pay(data[0].snap_token, {
            onSuccess: function(result) {
                window.location.href = '{{ route("paywall.callback") }}?order_id=' + result.order_id + '&status_code=200&transaction_status=' + result.transaction_status;
            },
            onPending: function(result) {
                window.location.href = '{{ route("paywall.callback") }}?order_id=' + result.order_id + '&status_code=201&transaction_status=' + result.transaction_status;
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User closed the popup
            }
        });
    });
</script>
@endscript
