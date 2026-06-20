<div class="flex flex-col min-h-full">
    <div class="bg-purple-700 px-5 pt-13 pb-5">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-3">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h2 class="text-xl font-semibold text-white">Notifikasi</h2>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pb-6" style="scrollbar-width:none">
        @forelse ($notifications as $notif)
            <div class="bg-white border border-gray-200 rounded-2xl p-3 mt-3">
                <div class="flex gap-2.5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $notif->type === 'income' ? 'bg-emerald-50' : ($notif->type === 'expense' ? 'bg-amber-50' : 'bg-purple-50') }}">
                        <i class="ti ti-{{ $notif->type === 'income' ? 'arrow-down-circle' : ($notif->type === 'expense' ? 'alert-triangle' : 'crown') }}
                            {{ $notif->type === 'income' ? 'text-emerald-600' : ($notif->type === 'expense' ? 'text-amber-600' : 'text-purple-600') }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ $notif->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $notif->message }}</p>
                        <p class="text-[11px] text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <i class="ti ti-bell-off text-gray-300 text-5xl"></i>
                <p class="text-sm text-gray-400 mt-3">Belum ada notifikasi</p>
            </div>
        @endforelse
    </div>
</div>
