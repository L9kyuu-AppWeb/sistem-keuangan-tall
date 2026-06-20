<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-4 text-white">
        <h1 class="text-xl font-semibold">Dompet Virtual</h1>
        <p class="text-xs opacity-80 mt-0.5">Kelola pos-pos saldo Anda</p>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        @if (session('success'))
            <div class="text-xs text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl p-3 mt-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 mt-4">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-2 gap-2.5 mt-4">
            <div class="bg-purple-50 rounded-xl p-3">
                <label class="text-[11px] text-purple-600 block">Total Saldo</label>
                <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
            </div>
            <div class="bg-purple-50 rounded-xl p-3">
                <label class="text-[11px] text-purple-600 block">Pos Aktif</label>
                <div class="text-lg font-semibold text-gray-900">{{ $walletCount }} / {{ $limit === PHP_INT_MAX ? '∞' : $limit }}</div>
                @if (!$atLimit)<div class="text-[11px] text-gray-500 mt-1">Batas Free</div>@endif
            </div>
        </div>

        @foreach ($wallets as $wallet)
            <a href="{{ route('wallet.detail', $wallet) }}" class="flex items-center gap-3 bg-purple-50 border border-purple-200 rounded-xl px-3.5 py-3 mt-2.5 cursor-pointer">
                <i class="ti ti-{{ $wallet->icon }} text-purple-600 text-2xl"></i>
                <div>
                    <div class="text-sm font-medium text-gray-900">{{ $wallet->name }}</div>
                    <div class="text-xs text-gray-500">Diperbarui {{ $wallet->updated_at->diffForHumans() }}</div>
                </div>
                <div class="ml-auto text-base font-semibold text-gray-900">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</div>
            </a>
        @endforeach

        @if ($atLimit && !auth()->user()->isPro())
            <div class="border-2 border-dashed border-purple-200 bg-purple-50/50 rounded-2xl text-center p-5 mt-3 cursor-pointer">
                <i class="ti ti-lock text-purple-600 text-3xl"></i>
                <p class="text-sm font-semibold text-purple-700 mt-2">Tambah Dompet Baru</p>
                <p class="text-xs text-gray-500 mt-1">Batas Free: 2 dompet. Upgrade Pro untuk dompet tak terbatas.</p>
                <a href="{{ route('paywall') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white rounded-xl px-4 py-2.5 text-xs font-semibold mt-3">
                    <i class="ti ti-crown"></i> Upgrade ke Pro
                </a>
            </div>
        @else
            <button wire:click="$toggle('showCreate')" class="flex items-center justify-center gap-2 w-full mt-3 py-3.5 rounded-xl text-sm font-semibold text-purple-600 border-2 border-dashed border-purple-200 bg-purple-50/50 cursor-pointer">
                <i class="ti ti-plus"></i> Tambah Dompet Baru
            </button>
        @endif

        @if ($showCreate)
            <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
                <p class="font-semibold text-sm mb-3">Dompet Baru</p>
                <div class="mb-3">
                    <label class="text-xs text-gray-500 mb-1 block">Nama Dompet</label>
                    <input wire:model="name" type="text" placeholder="Contoh: Gopay" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="text-xs text-gray-500 mb-1 block">Tipe</label>
                    <select wire:model="type" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                        <option value="cash">Uang Tunai</option>
                        <option value="bank">Rekening Bank</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>
                <button wire:click="create" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold bg-purple-600 text-white">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-4 mb-4">
            <p class="font-semibold text-base">Pindah Saldo Antar Dompet</p>
            <div class="mt-3">
                <label class="text-xs text-gray-500 mb-1 block">Dari</label>
                <select wire:model="transferFrom" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                    <option value="">Pilih dompet</option>
                    @foreach ($wallets as $w)
                        <option value="{{ $w->id }}">{{ $w->name }} (Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <label class="text-xs text-gray-500 mb-1 block">Ke</label>
                <select wire:model="transferTo" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                    <option value="">Pilih dompet</option>
                    @foreach ($wallets as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
                @error('transferTo') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mt-3">
                <label class="text-xs text-gray-500 mb-1 block">Jumlah</label>
                <input wire:model="transferAmount" type="number" placeholder="Rp 0" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                @error('transferAmount') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            @if (session('transfer_error'))
                <div class="text-xs text-red-600 bg-red-50 rounded-lg p-2 mt-2">{{ session('transfer_error') }}</div>
            @endif
            @if (session('transfer_success'))
                <div class="text-xs text-emerald-600 bg-emerald-50 rounded-lg p-2 mt-2">{{ session('transfer_success') }}</div>
            @endif
            <button wire:click="transfer" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold bg-purple-600 text-white mt-3">
                <i class="ti ti-arrows-exchange"></i> Pindahkan Saldo
            </button>
        </div>
    </div>

    <a href="{{ route('transaction.create') }}" class="fixed bottom-[76px] right-1/2 -mr-[179px] w-13 h-13 bg-purple-600 rounded-full flex items-center justify-center text-white text-2xl shadow-lg shadow-purple-400/40 z-10">
        <i class="ti ti-plus"></i>
    </a>

    <livewire:layouts.bottom-nav />
</div>
