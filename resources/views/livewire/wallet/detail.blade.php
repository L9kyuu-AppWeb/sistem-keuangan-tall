<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-5">
        <a href="{{ route('wallets') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-3">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="ti ti-{{ $wallet->icon }}" style="font-size:26px;color:#fff"></i>
            </div>
            <div>
                <p class="text-xs text-white/75">{{ $wallet->type === 'cash' ? 'Uang Tunai' : ($wallet->type === 'bank' ? 'Rekening Tabungan' : 'E-Wallet') }}</p>
                <h2 class="text-xl font-semibold text-white">{{ $wallet->name }}</h2>
            </div>
        </div>
        <p class="text-xs text-white/70">Saldo Saat Ini</p>
        <p class="text-3xl font-bold text-white">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</p>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-6" style="scrollbar-width:none">
        <div class="flex bg-gray-100 rounded-xl p-0.5 mt-4">
            <button wire:click="$set('filter', 'all')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $filter === 'all' ? 'bg-purple-600 text-white' : 'text-gray-500' }}">Semua</button>
            <button wire:click="$set('filter', 'income')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $filter === 'income' ? 'bg-purple-600 text-white' : 'text-gray-500' }}">Masuk</button>
            <button wire:click="$set('filter', 'expense')" class="flex-1 py-2 rounded-lg text-xs font-medium {{ $filter === 'expense' ? 'bg-purple-600 text-white' : 'text-gray-500' }}">Keluar</button>
        </div>

        @forelse ($transactions as $txn)
            <div class="flex items-center gap-3 py-2.5 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg flex-shrink-0
                    {{ $txn->type === 'income' ? 'bg-emerald-50 text-emerald-600' : ($txn->type === 'expense' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-600') }}">
                    <i class="ti ti-{{ $txn->type === 'income' ? 'arrow-down-circle' : ($txn->type === 'expense' ? 'shopping-cart' : 'arrows-exchange') }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $txn->description ?? 'Transaksi' }}</p>
                    <span class="text-xs text-gray-500">{{ $txn->date->isoFormat('D MMM') }}</span>
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
            <p class="text-sm text-gray-400 text-center py-8">Belum ada transaksi di dompet ini.</p>
        @endforelse
    </div>
</div>
