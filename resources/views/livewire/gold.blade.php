<div class="flex flex-col min-h-full">
    <div class="bg-amber-800 px-5 pt-13 pb-4 text-white">
        <h1 class="text-xl font-semibold">Dompet Emas</h1>
        <p class="text-xs opacity-80 mt-0.5">Portofolio aset emas keluarga</p>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        <div class="bg-amber-800 text-white rounded-2xl p-4 mt-4">
            <div class="text-xs opacity-75">Total Gramasi Emas</div>
            <div class="text-2xl font-bold">{{ number_format($totalGrams, 2, ',', '.') }} gram</div>
            <div class="flex gap-2.5 mt-3">
                <div class="flex-1 bg-black/20 rounded-lg p-2">
                    <div class="text-[11px] opacity-75">Harga Beli Rata-rata</div>
                    <div class="text-sm font-semibold">Rp {{ number_format($avgPrice, 0, ',', '.') }}/gr</div>
                </div>
                <div class="flex-1 bg-black/20 rounded-lg p-2">
                    <div class="text-[11px] opacity-75">Total Modal</div>
                    <div class="text-sm font-semibold">Rp {{ number_format($totalCost, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        @if (!auth()->user()->isPro())
            <div class="relative bg-white border border-gray-200 rounded-2xl mt-3 overflow-hidden">
                <div class="p-4 blur-sm pointer-events-none select-none">
                    <p class="font-semibold text-base mb-3">Nilai Pasar & Keuntungan</p>
                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="bg-purple-50 rounded-xl p-3">
                            <label class="text-[11px] text-purple-600 block">Harga Emas Hari Ini</label>
                            <div class="text-lg font-semibold text-gray-900">Rp 1.085.000</div>
                            <div class="text-[11px] text-gray-500 mt-1">per gram</div>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-3">
                            <label class="text-[11px] text-purple-600 block">Nilai Pasar</label>
                            <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalGrams * 1085000, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="h-20 bg-gray-100 rounded-xl mt-3"></div>
                </div>
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/75 gap-2">
                    <i class="ti ti-crown text-purple-600 text-3xl"></i>
                    <p class="text-xs text-purple-700 font-semibold text-center px-6">Aktifkan Pro untuk harga emas real-time & grafik keuntungan otomatis</p>
                    <a href="{{ route('paywall') }}" class="bg-purple-600 text-white rounded-xl px-5 py-2.5 text-xs font-semibold">Coba Pro Gratis</a>
                </div>
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
                <p class="font-semibold text-base mb-3">Nilai Pasar & Keuntungan</p>
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="bg-purple-50 rounded-xl p-3">
                        <label class="text-[11px] text-purple-600 block">Harga Emas Hari Ini</label>
                        <div class="text-lg font-semibold text-gray-900">Rp 1.085.000</div>
                        <div class="text-[11px] text-gray-500 mt-1">per gram</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-3">
                        <label class="text-[11px] text-purple-600 block">Nilai Pasar</label>
                        <div class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalGrams * 1085000, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-emerald-50 rounded-xl">
                    <div class="flex justify-between text-sm">
                        <span class="text-emerald-700 font-medium">Gain/Loss</span>
                        <span class="font-semibold text-emerald-600">
                            Rp {{ number_format(($totalGrams * 1085000) - $totalCost, 0, ',', '.') }}
                            ({{ $totalCost > 0 ? number_format((($totalGrams * 1085000) - $totalCost) / $totalCost * 100, 1) : 0 }}%)
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
            <p class="font-semibold text-base mb-3">Catat Transaksi Emas</p>
            <div class="flex bg-gray-100 rounded-xl p-0.5 mb-4">
                <button wire:click="$set('type', 'buy')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $type === 'buy' ? 'bg-purple-600 text-white' : 'text-gray-500' }}">Beli</button>
                <button wire:click="$set('type', 'sell')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $type === 'sell' ? 'bg-purple-600 text-white' : 'text-gray-500' }}">Jual</button>
            </div>
            @if (session('success'))
                <div class="text-xs text-emerald-600 bg-emerald-50 rounded-lg p-2 mb-3">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="text-xs text-red-600 bg-red-50 rounded-lg p-2 mb-3">{{ session('error') }}</div>
            @endif
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Jumlah (Gram)</label>
                <input wire:model="grams" type="number" step="0.001" placeholder="0,5" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                @error('grams') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Harga {{ $type === 'buy' ? 'Beli' : 'Jual' }} per Gram</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                    <input wire:model="pricePerGram" type="number" placeholder="985000" class="w-full pl-9 pr-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                </div>
                @error('pricePerGram') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Tanggal</label>
                <input wire:model="date" type="date" class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
                @error('date') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="text-xs text-gray-500 mb-1 block">Catatan (Opsional)</label>
                <input wire:model="notes" type="text" placeholder="..." class="w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:border-purple-600 outline-none">
            </div>
            <button wire:click="save" class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-sm font-semibold bg-purple-600 text-white">
                <i class="ti ti-check"></i> Simpan
            </button>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3 mb-4">
            <p class="font-semibold text-base mb-3">Riwayat Transaksi Emas</p>
            @forelse ($holdings as $h)
                <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-amber-50 text-amber-600">
                        <i class="ti ti-star"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ $h->type === 'buy' ? 'Beli' : 'Jual' }} Emas</p>
                        <span class="text-xs text-gray-500">{{ $h->date->isoFormat('D MMM Y') }} · {{ $h->grams }} gram</span>
                    </div>
                    <div class="text-sm font-semibold text-red-500">-Rp {{ number_format($h->total_cost, 0, ',', '.') }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">Belum ada transaksi emas.</p>
            @endforelse
        </div>
    </div>

    <livewire:layouts.bottom-nav />
</div>
