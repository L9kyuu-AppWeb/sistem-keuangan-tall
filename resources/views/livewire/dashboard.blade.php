@php
    $monthName = now()->locale('id')->isoFormat('MMMM Y');

    $totalIncome = auth()->user()->transactions()
        ->where('type', 'income')
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->sum('amount');

    $totalExpense = auth()->user()->transactions()
        ->where('type', 'expense')
        ->whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->sum('amount');

    $netWorth = auth()->user()->wallets()->sum('balance');

    $budget = auth()->user()->budgets()
        ->where('month', now()->format('Y-m'))
        ->whereNull('category_id')
        ->first();

    $budgetAmount = $budget?->amount ?? 5000000;
    $budgetPercent = $budgetAmount > 0 ? min(100, round(($totalExpense / $budgetAmount) * 100)) : 0;
    $budgetRemaining = $budgetAmount - $totalExpense;

    $recentTransactions = auth()->user()->transactions()
        ->with(['wallet', 'category'])
        ->latest()
        ->take(4)
        ->get();

    $tips = collect([
        ['icon' => 'bulb', 'text' => 'Coba atur anggaran bulanan untuk mengontrol pengeluaran keluarga.'],
        ['icon' => 'bulb', 'text' => 'Pengeluaran "Makan" Anda naik. Pertimbangkan masak di rumah!'],
        ['icon' => 'bulb', 'text' => 'Rutin menabung 10% dari pemasukan setiap bulan.'],
    ])->random();
@endphp
<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-4 text-white">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs opacity-75">Selamat pagi,</p>
                <h1 class="text-xl font-semibold">{{ auth()->user()->name }}</h1>
            </div>
            <a href="{{ route('notifications') }}" class="bg-white/20 rounded-xl w-9 h-9 flex items-center justify-center text-white">
                <i class="ti ti-bell text-xl"></i>
            </a>
        </div>
        <div class="inline-flex items-center gap-1 bg-white/20 rounded-full px-2.5 py-0.5 text-[11px] text-white mt-2">
            <i class="ti ti-crown text-xs"></i>
            {{ auth()->user()->isPro() ? 'Akun Pro' : 'Akun Gratis' }}
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-24" style="scrollbar-width:none">
        <div class="bg-purple-900 text-white rounded-2xl p-4 mt-4">
            <p class="text-xs opacity-80">Total Kekayaan Bersih</p>
            <p class="text-3xl font-bold mt-1">Rp {{ number_format($netWorth, 0, ',', '.') }}</p>
            <div class="flex gap-3 mt-2.5">
                <div class="flex-1 bg-white/15 rounded-lg p-2">
                    <p class="text-[11px] opacity-75">Pemasukan Bulan Ini</p>
                    <p class="text-[15px] font-semibold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="flex-1 bg-white/15 rounded-lg p-2">
                    <p class="text-[11px] opacity-75">Pengeluaran</p>
                    <p class="text-[15px] font-semibold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
            <div class="flex justify-between items-center mb-3">
                <p class="font-semibold text-base">Anggaran Bulan Ini</p>
                <span class="text-xs bg-purple-100 text-purple-700 font-semibold rounded-full px-2 py-0.5">1/1 Free</span>
            </div>
            <div class="mb-2">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Total Pengeluaran</span>
                    <span class="text-gray-700 font-medium">Rp {{ number_format($totalExpense, 0, ',', '.') }} / Rp {{ number_format($budgetAmount, 0, ',', '.') }}</span>
                </div>
                <div class="h-2 bg-purple-100 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-600 rounded-full" style="width:{{ $budgetPercent }}%"></div>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Sisa anggaran: <b class="text-purple-600">Rp {{ number_format(max(0, $budgetRemaining), 0, ',', '.') }}</b>
            </p>
            <a href="{{ route('budget') }}" class="flex items-center justify-center gap-2 w-full mt-3 py-2.5 rounded-xl text-sm font-semibold text-[#970747] border border-[#970747] bg-white">
                <i class="ti ti-chart-pie"></i> Atur Anggaran
                @if (!auth()->user()->isPro())
                    <span class="text-xs bg-amber-100 text-amber-700 font-semibold rounded-full px-1.5 py-0.5">Pro</span>
                @endif
            </a>
        </div>

        <div class="flex items-start gap-2 bg-amber-50 border border-amber-200 rounded-xl p-3 mt-3 text-amber-800 text-xs">
            <i class="ti ti-bulb text-amber-500 text-lg flex-shrink-0 mt-0.5"></i>
            <span><b>Tips hari ini:</b> {{ $tips['text'] }}</span>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-4 mt-3">
            <div class="flex justify-between items-center mb-1">
                <p class="font-semibold text-base">Transaksi Terakhir</p>
                <a href="{{ route('transactions') }}" class="text-xs text-purple-600">Lihat semua</a>
            </div>
            @forelse ($recentTransactions as $txn)
                <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 last:border-b-0">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-lg flex-shrink-0
                        {{ $txn->type === 'income' ? 'bg-emerald-50 text-emerald-600' : ($txn->type === 'expense' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-600') }}">
                        <i class="ti ti-{{ $txn->type === 'income' ? 'arrow-down-circle' : ($txn->type === 'expense' ? 'shopping-cart' : 'arrows-exchange') }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $txn->description ?? 'Transaksi' }}</p>
                        <span class="text-xs text-gray-500">{{ $txn->date->isoFormat('D MMM') }} · {{ $txn->wallet?->name }}</span>
                    </div>
                    <div class="font-semibold text-sm {{ $txn->type === 'income' ? 'text-emerald-600' : ($txn->type === 'expense' ? 'text-red-500' : 'text-blue-600') }}">
                        @if ($txn->type === 'income')
                            +{{ number_format($txn->amount, 0, ',', '.') }}
                        @elseif ($txn->type === 'expense')
                            -{{ number_format($txn->amount, 0, ',', '.') }}
                        @else
                            Pindah
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">Belum ada transaksi. Mulai catat sekarang!</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('transaction.create') }}" class="fixed bottom-[76px] right-1/2 -mr-[179px] w-13 h-13 bg-purple-600 rounded-full flex items-center justify-center text-white text-2xl shadow-lg shadow-purple-400/40 z-10">
        <i class="ti ti-plus"></i>
    </a>

    <livewire:layouts.bottom-nav />
</div>
