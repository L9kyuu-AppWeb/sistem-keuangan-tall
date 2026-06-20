<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-4 text-white">
        <h1 class="text-xl font-semibold">Bagi Buku Keluarga</h1>
        <p class="text-xs opacity-80 mt-0.5">Sinkronisasi pencatatan bersama pasangan</p>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        <div class="bg-purple-50 border border-purple-200 rounded-2xl p-4 mt-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white">
                    <i class="ti ti-user"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Anda (Pemilik Buku)</p>
                </div>
                <span class="text-xs ml-auto bg-purple-100 text-purple-700 font-semibold rounded-full px-2 py-0.5">Free</span>
            </div>

            @if (auth()->user()->isPro())
                <div class="bg-white rounded-xl p-4 border border-gray-200">
                    <p class="font-semibold text-sm mb-2">Family Sync Aktif</p>
                    @if (auth()->user()->familyGroup)
                        <p class="text-xs text-gray-500">Kode grup: <b class="text-purple-600">{{ auth()->user()->familyGroup->code }}</b></p>
                        <p class="text-xs text-gray-500 mt-1">Anggota: {{ auth()->user()->familyGroup->members->count() }} orang</p>
                    @else
                        <p class="text-xs text-gray-500">Belum terhubung dengan pasangan.</p>
                        <p class="text-xs text-gray-500 mt-1">Bagikan kode undangan untuk menghubungkan akun.</p>
                    @endif
                </div>
            @else
                <div class="text-center py-6 px-4 border-2 border-dashed border-purple-200 rounded-xl">
                    <i class="ti ti-lock text-purple-600 text-4xl"></i>
                    <p class="text-sm font-semibold text-purple-700 mt-2.5">Hubungkan Akun Pasangan</p>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Fitur Family Sync memungkinkan Anda dan pasangan mencatat pengeluaran bersama secara real-time dari perangkat masing-masing.
                    </p>
                    <a href="{{ route('paywall') }}" class="flex items-center justify-center gap-2 w-full mt-4 py-3 rounded-xl text-sm font-semibold bg-purple-600 text-white">
                        <i class="ti ti-crown"></i> Upgrade ke Pro
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
            <p class="font-semibold text-base mb-3">Cara Kerja Family Sync</p>
            <div class="flex items-start gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                <i class="ti ti-user-plus text-purple-600 text-xl flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium">Hubungkan akun pasangan</p>
                    <span class="text-xs text-gray-500">Kirim undangan lewat email atau kode unik</span>
                </div>
            </div>
            <div class="flex items-start gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                <i class="ti ti-pencil text-purple-600 text-xl flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium">Catat dari perangkat masing-masing</p>
                    <span class="text-xs text-gray-500">Suami catat di HP-nya, istri di HP-nya</span>
                </div>
            </div>
            <div class="flex items-start gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                <i class="ti ti-refresh text-purple-600 text-xl flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium">Sinkronisasi otomatis real-time</p>
                    <span class="text-xs text-gray-500">Saldo & anggaran langsung terupdate bersama</span>
                </div>
            </div>
            <div class="flex items-start gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                <i class="ti ti-chart-pie text-purple-600 text-xl flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium">Satu laporan keuangan keluarga</p>
                    <span class="text-xs text-gray-500">Tidak perlu transfer catatan manual lagi</span>
                </div>
            </div>
        </div>
    </div>

    <livewire:layouts.bottom-nav />
</div>
