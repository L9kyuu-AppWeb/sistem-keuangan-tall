<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-5">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-3">
            <i class="ti ti-x"></i> Batal
        </a>
        <h2 class="text-xl font-semibold text-white">Catat Transaksi</h2>
        <div class="flex bg-white/10 rounded-xl p-0.5 mt-4">
            <button wire:click="$set('type', 'expense')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $type === 'expense' ? 'bg-white text-purple-700' : 'text-white/80' }}">Pengeluaran</button>
            <button wire:click="$set('type', 'income')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $type === 'income' ? 'bg-white text-purple-700' : 'text-white/80' }}">Pemasukan</button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-6" style="scrollbar-width:none">
        @if (session('error'))
            <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 mt-4">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="text-xs text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl p-3 mt-4">{{ session('success') }}</div>
        @endif

        <div class="mb-3 mt-4">
            <label class="text-xs text-gray-500 mb-1 block">Jumlah</label>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                <input wire:model="amount" type="number" placeholder="0" class="w-full pl-9 pr-3.5 py-3 border border-gray-300 rounded-xl text-xl font-semibold focus:border-purple-600 outline-none">
            </div>
            @error('amount') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="text-xs text-gray-500 mb-1 block">Dompet</label>
            <select wire:model="walletId" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                @foreach ($wallets as $w)
                    <option value="{{ $w->id }}">{{ $w->name }} (Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                @endforeach
            </select>
            @error('walletId') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        @if ($type === 'expense')
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Kategori</label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach ($categories as $cat)
                        <div wire:click="$set('categoryId', '{{ $cat->id }}')" class="text-center p-2 rounded-xl cursor-pointer {{ $categoryId == $cat->id ? 'bg-purple-100 border border-purple-200' : 'bg-gray-50' }}">
                            <i class="ti ti-{{ $cat->icon }} text-xl {{ $categoryId == $cat->id ? 'text-purple-600' : 'text-gray-500' }} block mb-1"></i>
                            <span class="text-[10px] {{ $categoryId == $cat->id ? 'text-purple-700' : 'text-gray-500' }}">{{ $cat->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label class="text-xs text-gray-500 mb-1 block">Catatan (Opsional)</label>
            <input wire:model="description" type="text" placeholder="Contoh: Beli sayur di pasar..." class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
        </div>

        <div class="mb-3">
            <label class="text-xs text-gray-500 mb-1 block">Tanggal</label>
            <input wire:model="date" type="date" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
            @error('date') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <button wire:click="save" class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-sm font-semibold bg-purple-600 text-white">
            <i class="ti ti-check"></i> Simpan Transaksi
        </button>
    </div>
</div>
