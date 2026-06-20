<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-4 text-white">
        <div class="flex items-center gap-3">
            <div class="w-13 h-13 rounded-full bg-white/30 flex items-center justify-center text-lg font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <h1 class="text-lg font-semibold">{{ auth()->user()->name }}</h1>
                <p class="text-xs opacity-80">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="flex gap-2 mt-3 items-center">
            <span class="text-xs bg-purple-100 text-purple-700 font-semibold rounded-full px-2.5 py-1">{{ auth()->user()->isPro() ? 'Akun Pro' : 'Akun Gratis' }}</span>
            @if (!auth()->user()->isPro())
                <a href="{{ route('paywall') }}" class="bg-white text-purple-600 rounded-xl px-3.5 py-1.5 text-xs font-semibold">
                    <i class="ti ti-crown"></i> Upgrade Pro
                </a>
            @endif
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-4">
            <p class="font-semibold text-base mb-3">Ringkasan Penggunaan</p>
            <div class="grid grid-cols-2 gap-2.5">
                <div class="bg-purple-50 rounded-xl p-3">
                    <label class="text-[11px] text-purple-600 block">Dompet Virtual</label>
                    <div class="text-lg font-semibold text-gray-900">{{ $walletCount }} / {{ auth()->user()->walletLimit() === PHP_INT_MAX ? '∞' : auth()->user()->walletLimit() }}</div>
                    <div class="text-[11px] text-gray-500 mt-1">{{ auth()->user()->isPro() ? 'Pro' : 'Batas Free' }}</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-3">
                    <label class="text-[11px] text-purple-600 block">Total Transaksi</label>
                    <div class="text-lg font-semibold text-gray-900">{{ $txnCount }}</div>
                    <div class="text-[11px] text-gray-500 mt-1">Bulan ini</div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl mt-3 overflow-hidden">
            <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-bell text-purple-600 text-xl"></i>
                <span class="text-sm flex-1">Notifikasi</span>
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('categories') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-tag text-purple-600 text-xl"></i>
                <span class="text-sm flex-1">Kategori</span>
                @if (!auth()->user()->isPro())
                    <span class="text-xs bg-amber-100 text-amber-700 font-semibold rounded-full px-1.5 py-0.5">Pro</span>
                @endif
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('family') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-users text-purple-600 text-xl"></i>
                <span class="text-sm flex-1">Family Sync</span>
                @if (!auth()->user()->isPro())
                    <span class="text-xs bg-amber-100 text-amber-700 font-semibold rounded-full px-1.5 py-0.5">Pro</span>
                @endif
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('paywall') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-crown text-amber-600 text-xl"></i>
                <span class="text-sm flex-1">Akses Pro & Berlangganan</span>
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('change-password') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-lock text-purple-600 text-xl"></i>
                <span class="text-sm flex-1">Ubah Kata Sandi</span>
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <a href="{{ route('export') }}" class="flex items-center gap-3 px-4 py-3.5 border-b border-gray-100">
                <i class="ti ti-download text-purple-600 text-xl"></i>
                <span class="text-sm flex-1">Ekspor Data</span>
                @if (!auth()->user()->isPro())
                    <span class="text-xs bg-amber-100 text-amber-700 font-semibold rounded-full px-1.5 py-0.5">Pro</span>
                @endif
                <i class="ti ti-chevron-right text-gray-300"></i>
            </a>
            <div class="flex items-center gap-3 px-4 py-3.5">
                <i class="ti ti-help-circle text-gray-500 text-xl"></i>
                <span class="text-sm flex-1">Pusat Bantuan</span>
                <i class="ti ti-chevron-right text-gray-300"></i>
            </div>
        </div>

        <button wire:click="logout" class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-sm font-semibold bg-red-50 text-red-500 mt-3 border-none cursor-pointer">
            <i class="ti ti-logout"></i> Keluar
        </button>
    </div>

    <livewire:layouts.bottom-nav />
</div>
