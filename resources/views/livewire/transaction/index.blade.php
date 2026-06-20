<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-5">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-3">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h2 class="text-xl font-semibold text-white">Semua Transaksi</h2>
        <div class="flex gap-2 mt-3">
            <div class="flex-1 relative">
                <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-white/50 text-sm"></i>
                <input wire:model.live="search" type="text" placeholder="Cari transaksi..." class="w-full bg-white/20 border-none rounded-xl py-2.5 pl-9 pr-3 text-white text-xs placeholder-white/50">
            </div>
            <button class="bg-white/20 border-none rounded-xl px-3 text-white cursor-pointer"><i class="ti ti-filter text-lg"></i></button>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-6" style="scrollbar-width:none">
        <div class="grid grid-cols-2 gap-2.5 mt-4">
            <div class="bg-emerald-50 rounded-xl p-3">
                <label class="text-[11px] text-emerald-600 block">Total Masuk</label>
                <div class="text-lg font-semibold text-emerald-600">+Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
            <div class="bg-red-50 rounded-xl p-3">
                <label class="text-[11px] text-red-500 block">Total Keluar</label>
                <div class="text-lg font-semibold text-red-500">-Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
        </div>

        @php $currentDate = null; @endphp
        @forelse ($transactions as $txn)
            @php $dateStr = $txn->date->isoFormat('D MMMM Y'); @endphp
            @if ($dateStr !== $currentDate)
                <p class="text-xs text-gray-400 mb-2 mt-4">{{ $dateStr }}</p>
                @php $currentDate = $dateStr; @endphp
            @endif
            <div class="flex items-center gap-3 py-2.5 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg flex-shrink-0
                    {{ $txn->type === 'income' ? 'bg-emerald-50 text-emerald-600' : ($txn->type === 'expense' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-600') }}">
                    <i class="ti ti-{{ $txn->type === 'income' ? 'arrow-down-circle' : ($txn->type === 'expense' ? 'shopping-cart' : 'arrows-exchange') }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $txn->description ?? 'Transaksi' }}</p>
                    <span class="text-xs text-gray-500">{{ $txn->wallet?->name }} · {{ $txn->category?->name ?? ucfirst($txn->type) }}</span>
                </div>
                <div class="font-semibold text-sm {{ $txn->type === 'income' ? 'text-emerald-600' : ($txn->type === 'expense' ? 'text-red-500' : 'text-blue-600') }}">
                    @if ($txn->type === 'income')
                        +{{ number_format($txn->amount, 0, ',', '.') }}
                    @elseif ($txn->type === 'expense')
                        -{{ number_format($txn->amount, 0, ',', '.') }}
                    @else
                        {{ number_format($txn->amount, 0, ',', '.') }}
                    @endif
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400 text-center py-8">Belum ada transaksi.</p>
        @endforelse

        @if (auth()->user()->isPro())
            <a href="{{ route('export') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-semibold text-[#970747] border border-[#970747] bg-white mt-4 text-decoration-none">
                <i class="ti ti-download"></i> Ekspor Data
            </a>
        @else
            <div class="bg-purple-50 border border-dashed border-purple-200 rounded-2xl text-center p-5 mt-4">
                <i class="ti ti-download text-purple-600 text-3xl"></i>
                <p class="text-sm font-semibold text-purple-700 mt-2">Ekspor ke Excel / PDF</p>
                <p class="text-xs text-gray-500 mt-1">Fitur ekspor tersedia untuk akun Pro.</p>
                <a href="{{ route('paywall') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white rounded-xl px-4 py-2.5 text-xs font-semibold mt-3">
                    <i class="ti ti-crown"></i> Upgrade Pro
                </a>
            </div>
        @endif
    </div>
</div>
