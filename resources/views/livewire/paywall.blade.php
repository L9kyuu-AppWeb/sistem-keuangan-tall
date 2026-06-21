<div class="flex flex-col min-h-full" x-data="{ selectedPlan: 'yearly' }">
    {{-- Header --}}
    <div style="background: linear-gradient(to bottom, #970747, #7c0639);" class="text-center px-5 pt-13 pb-4 relative overflow-hidden flex-shrink-0">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>

        <a href="{{ route('profile') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-4 hover:text-white transition-colors relative z-10">
            <i class="ti ti-x"></i> Tutup
        </a>

        <div class="relative z-10">
            <i class="ti ti-crown text-amber-300 text-4xl block" style="filter:drop-shadow(0 2px 8px rgba(252,211,77,0.4))"></i>
            <h2 class="text-2xl font-bold mt-1 text-white">FamiBalance Pro</h2>
            <p class="text-xs text-white/80 mt-0.5">Kelola keuangan keluarga tanpa batas dan lebih terencana</p>
        </div>

        @if($alreadyUsedTrial)
        <div class="mt-3 inline-flex items-center gap-1.5 bg-amber-500/20 border border-amber-400/30 text-white text-xs px-3 py-1.5 rounded-full">
            <i class="ti ti-info-circle"></i> Trial sudah digunakan
        </div>
        @elseif($isPro)
        <div class="mt-3 inline-flex items-center gap-1.5 bg-green-500/20 border border-green-400/30 text-green-200 text-xs px-3 py-1.5 rounded-full">
            <i class="ti ti-crown"></i> Pro Aktif
        </div>
        @endif

        {{-- Pricing Cards --}}
        <div class="flex gap-3 mt-5 justify-center relative z-10" style="max-width:300px;margin-left:auto;margin-right:auto">
            <div
                @click="selectedPlan = 'monthly'"
                class="flex-1 rounded-2xl pt-4 pb-3 px-3.5 cursor-pointer text-center transition-all duration-300 border"
                :class="selectedPlan === 'monthly' ? 'border-white' : 'border-white/30'"
                :style="selectedPlan === 'monthly' ? 'background:#fff' : 'background:rgba(255,255,255,0.1)'"
            >
                <div class="font-medium tracking-wide uppercase" :style="selectedPlan === 'monthly' ? 'color:#9ca3af;font-size:11px' : 'color:rgba(255,255,255,0.8);font-size:11px'">Bulanan</div>
                <div class="text-xl font-extrabold mt-1" :style="selectedPlan === 'monthly' ? 'color:#970747' : 'color:#fff'">Rp 29rb</div>
                <div :style="selectedPlan === 'monthly' ? 'color:#9ca3af;font-size:10px' : 'color:rgba(255,255,255,0.7);font-size:10px'">/bulan</div>
            </div>

            <div
                @click="selectedPlan = 'yearly'"
                class="flex-1 rounded-2xl pt-4 pb-3 px-3.5 cursor-pointer text-center transition-all duration-300 relative border"
                :class="selectedPlan === 'yearly' ? 'border-white' : 'border-white/30'"
                :style="selectedPlan === 'yearly' ? 'background:#fff' : 'background:rgba(255,255,255,0.1)'"
            >
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 text-amber-950 font-black px-2.5 py-0.5 rounded-full shadow-md whitespace-nowrap tracking-wider" style="font-size:9px;background:linear-gradient(to right,#fbbf24,#f59e0b)">HEMAT 30%</div>
                <div class="font-medium tracking-wide uppercase" :style="selectedPlan === 'yearly' ? 'color:#9ca3af;font-size:11px' : 'color:rgba(255,255,255,0.8);font-size:11px'">Tahunan</div>
                <div class="text-xl font-extrabold mt-1" :style="selectedPlan === 'yearly' ? 'color:#970747' : 'color:#fff'">Rp 249rb</div>
                <div :style="selectedPlan === 'yearly' ? 'color:#9ca3af;font-size:10px' : 'color:rgba(255,255,255,0.7);font-size:10px'">/tahun</div>
            </div>
        </div>

        <div class="h-4 mt-2">
            <div x-show="selectedPlan === 'yearly'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="text-xs font-medium flex items-center justify-center gap-1" style="color:#fcd34b">
                <i class="ti ti-trending-down text-sm"></i> Hemat Rp 99rb/tahun
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        <p class="font-bold text-gray-900 text-base mt-4 mb-3">Yang Anda dapatkan</p>

        <div class="space-y-1">
            <div class="pw-feat">
                <i class="ti ti-wallet" style="color:#970747"></i>
                <div>
                    <p>Dompet Virtual Tak Terbatas</p>
                    <span>Tambah rekening, e-wallet, kas sebanyak yang Anda mau</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-star" style="color:#970747"></i>
                <div>
                    <p>Harga Emas Real-Time & Analisis</p>
                    <span>Grafik gain/loss otomatis setiap hari untuk investasi</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-users" style="color:#970747"></i>
                <div>
                    <p>Family Sync — Bagi Buku Berdua</p>
                    <span>Satu buku kas, dua perangkat, sinkronisasi real-time</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-chart-pie" style="color:#970747"></i>
                <div>
                    <p>Multi-Anggaran per Kategori</p>
                    <span>Budget terpisah untuk makan, tagihan, hiburan, dan lainnya</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-tag" style="color:#970747"></i>
                <div>
                    <p>Kategori Kustom Tak Terbatas</p>
                    <span>Buat dan kelola nama kategori bebas sesuai kebutuhan rumah tangga</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-camera" style="color:#970747"></i>
                <div>
                    <p>Lampiran Struk & Nota Digital</p>
                    <span>Simpan arsip foto struk belanja langsung di setiap transaksi</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-download" style="color:#970747"></i>
                <div>
                    <p>Ekspor Excel, CSV & PDF</p>
                    <span>Download laporan keuangan rapi untuk analisa bulanan/tahunan</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-ad-off" style="color:#970747"></i>
                <div>
                    <p>100% Bebas Iklan</p>
                    <span>Pengalaman penuh fokus mencatat tanpa distraksi iklan</span>
                </div>
            </div>
        </div>

        {{-- CTA Buttons --}}
        <div class="mt-6 space-y-3">
            @if(!$alreadyUsedTrial && !$isPro)
            <button
                wire:click="openConfirmModal"
                class="flex items-center justify-center gap-2 w-full py-4 rounded-xl text-base font-bold text-white"
                :style="selectedPlan === 'yearly' ? 'background:linear-gradient(to right,#970747,#b30855)' : 'background:#970747'"
                style="box-shadow:0 4px 6px -1px rgba(151,7,71,0.2)">
                <i class="ti ti-crown"></i> Mulai 7 Hari Gratis
            </button>
            <p class="text-center text-xs text-gray-400">Batalkan kapan saja, mudah, tanpa komitmen.</p>

            @elseif($isPro)
            <p class="text-center text-xs font-medium" style="color:#970747">Masa berlaku: {{ Auth::user()->pro_expires_at?->diffForHumans() ?? '-' }}</p>

            @else
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 text-center">
                <p class="text-sm font-medium text-gray-700">Masa Trial Gratis Anda Sudah Selesai</p>
                <p class="text-xs text-gray-400 mt-0.5">Pilih salah satu paket di atas untuk melanjutkan fitur Pro</p>
            </div>
            @endif

            <div class="flex gap-3 p-3.5 bg-gray-50 rounded-2xl border border-gray-100 mt-4">
                <i class="ti ti-shield-check text-xl flex-shrink-0" style="color:#970747"></i>
                <p class="leading-relaxed text-gray-500" style="font-size:11px">
                    <span class="font-semibold text-gray-700">Pernyataan Privasi:</span> FamiBalance hanya digunakan untuk pencatatan mandiri. Seluruh proses pembayaran aman dan kami <span class="underline">tidak pernah</span> mengakses atau menyimpan saldo rekening asli Anda.
                </p>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Trial --}}
    @if($showConfirmModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-5" style="background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px)">
        <div class="bg-white rounded-3xl w-full overflow-hidden shadow-2xl border border-gray-100" style="max-width:350px">
            <div class="text-white text-center pt-6 pb-5 px-5 relative overflow-hidden" style="background:linear-gradient(to right,#970747,#b30855)">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-xl"></div>
                <i class="ti ti-gift text-4xl block" style="color:#fcd34b;filter:drop-shadow(0 4px 6px rgba(0,0,0,0.1))"></i>
                <h3 class="text-lg font-bold mt-2">Aktifkan Trial Gratis</h3>
                <p class="text-xs text-white/80 mt-0.5">Nikmati 7 hari penuh akses tanpa batas</p>
            </div>

            <div class="p-5 space-y-3.5">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Penting Diketahui:</p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <i class="ti ti-clock text-lg flex-shrink-0 mt-0.5" style="color:#970747"></i>
                        <p class="text-xs text-gray-600 leading-normal">Berlaku selama <span class="font-semibold text-gray-800">7 hari</span>, setelah itu status akun otomatis kembali menjadi Free tanpa dipungut biaya.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="ti ti-credit-card-off text-lg flex-shrink-0 mt-0.5" style="color:#970747"></i>
                        <p class="text-xs text-gray-600 leading-normal"><span class="font-semibold text-gray-800">Tanpa Kartu Kredit</span> — Tidak ada tagihan otomatis ataupun biaya siluman setelah masa trial selesai.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="ti ti-repeat-off text-lg flex-shrink-0 mt-0.5" style="color:#970747"></i>
                        <p class="text-xs text-gray-600 leading-normal">Kesempatan terbatas <span class="font-semibold text-gray-800">1x per akun</span>. Gunakan secara maksimal untuk mengelola pengeluaran Anda.</p>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200/60 rounded-xl p-3 mt-2 flex gap-2">
                    <i class="ti ti-info-circle text-amber-600 text-base flex-shrink-0 mt-0.5"></i>
                    <p class="text-amber-800 leading-normal" style="font-size:11px">
                        Tenang, setelah trial berakhir data yang Anda masukkan tidak akan hilang atau dihapus.
                    </p>
                </div>
            </div>

            <div class="px-5 pb-5 pt-1 flex gap-3">
                <button
                    wire:click="closeConfirmModal"
                    class="flex-1 py-3 rounded-xl text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button
                    wire:click="confirmStartTrial"
                    class="flex-1 py-3 rounded-xl text-xs font-bold text-white hover:shadow-md transition-all flex items-center justify-center gap-1.5"
                    style="background:linear-gradient(to right,#970747,#b30855)">
                    <i class="ti ti-crown text-xs"></i> Ya, Aktifkan
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
