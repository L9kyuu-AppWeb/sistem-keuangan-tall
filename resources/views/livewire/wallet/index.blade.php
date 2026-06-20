<div class="flex flex-col min-h-full">
    {{-- TOPBAR --}}
    <div class="topbar" style="background:#970747">
        <h1>Dompet Virtual</h1>
        <p>Kelola pos-pos saldo Anda</p>
    </div>

    <div class="scroll-area">

        {{-- STATS --}}
        <div class="stat-row" style="margin-top:16px">
            <div class="stat">
                <label>Total Saldo</label>
                <div class="val">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
            </div>
            <div class="stat">
                <label>Pos Aktif</label>
                <div class="val">{{ $walletCount }} / {{ $limit === PHP_INT_MAX ? '∞' : $limit }}</div>
                @if (!$atLimit)<div class="sub">Batas Free</div>@endif
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="text-xs text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-xl p-3 mb-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-xl p-3 mb-3">{{ session('error') }}</div>
        @endif

        {{-- WALLET LIST --}}
        @foreach ($wallets as $wallet)

            {{-- EDIT FORM --}}
            @if ($editingId === $wallet->id)
                <div class="card" style="margin-bottom:10px">
                    <p style="font-size:15px;font-weight:600;color:#1a1a1a;margin-bottom:14px">Edit Dompet</p>
                    <div class="form-group">
                        <label class="form-label">Nama Dompet</label>
                        <input wire:model="editName" type="text" placeholder="Nama dompet"
                            class="form-input" style="font-size:14px">
                        @error('editName') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe</label>
                        <select wire:model="editType" class="form-input" style="font-size:14px">
                            <option value="cash">Uang Tunai</option>
                            <option value="bank">Rekening Bank</option>
                            <option value="ewallet">E-Wallet</option>
                        </select>
                    </div>
                    <div style="display:flex;gap:8px">
                        <button wire:click="update" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:14px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;border:none;background:#970747;color:#fff">
                            <i class="ti ti-check"></i> Simpan
                        </button>
                        <button wire:click="cancelEdit" style="display:flex;align-items:center;justify-content:center;padding:14px 20px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;border:none;background:#f4f4f4;color:#555;width:auto">
                            Batal
                        </button>
                    </div>
                </div>

            {{-- DELETE CONFIRM --}}
            @elseif ($deletingId === $wallet->id)
                <div class="card" style="margin-bottom:10px;text-align:center;border:1.5px solid #FECACA;background:#FEF2F2">
                    <i class="ti ti-alert-triangle" style="font-size:28px;color:#EF4444"></i>
                    <p style="font-size:14px;font-weight:600;color:#EF4444;margin-top:8px">Hapus "{{ $wallet->name }}"?</p>
                    <p style="font-size:12px;color:#888;margin-top:4px">Transaksi tetap tersimpan.</p>
                    <div style="display:flex;gap:8px;margin-top:14px">
                        <button wire:click="delete({{ $wallet->id }})" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:14px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;border:none;background:#EF4444;color:#fff">
                            <i class="ti ti-trash"></i> Ya, Hapus
                        </button>
                        <button wire:click="cancelDelete" style="display:flex;align-items:center;justify-content:center;padding:14px 20px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;border:none;background:#fff;color:#555;border:1.5px solid #ddd;width:auto">
                            Batal
                        </button>
                    </div>
                </div>

            {{-- WALLET CHIP --}}
            @else
                <div class="wallet-chip">
                    <i class="ti ti-{{ $wallet->icon }}"></i>
                    <div style="flex:1;min-width:0">
                        <div class="wname" style="{{ !$wallet->is_active ? 'color:#aaa;text-decoration:line-through' : '' }}">{{ $wallet->name }}</div>
                        <div class="wbal">{{ !$wallet->is_active ? 'Nonaktif' : \Carbon\Carbon::parse($wallet->updated_at)->diffForHumans() }}</div>
                    </div>
                    <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:4px">
                        <div class="wamt">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</div>
                        <div style="display:flex;gap:4px">
                            <button wire:click="edit({{ $wallet->id }})" title="Edit"
                                style="background:none;border:none;color:#970747;font-size:13px;cursor:pointer;padding:2px 4px;line-height:1">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $wallet->id }})" title="Hapus"
                                style="background:none;border:none;color:#EF4444;font-size:13px;cursor:pointer;padding:2px 4px;line-height:1">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <a href="{{ route('wallet.detail', $wallet) }}" style="display:block;text-align:right;font-size:11px;color:#970747;margin:-6px 6px 2px 0;text-decoration:none">
                    Lihat detail →
                </a>
            @endif
        @endforeach

        {{-- LIMIT / ADD BUTTON --}}
        @if ($atLimit && !auth()->user()->isPro())
            <div class="card" style="border:1.5px dashed #DDD6FE;background:#FAFAFF;text-align:center;padding:20px;cursor:pointer">
                <i class="ti ti-lock" style="font-size:28px;color:#970747"></i>
                <p style="font-size:14px;font-weight:600;color:#5B21B6;margin-top:8px">Tambah Dompet Baru</p>
                <p style="font-size:12px;color:#888;margin-top:4px">Batas Free: 2 dompet. Upgrade Pro untuk dompet tak terbatas.</p>
                <a href="{{ route('paywall') }}" class="btn btn-primary" style="margin-top:12px;padding:10px;font-size:13px;text-decoration:none;background:#970747">
                    <i class="ti ti-crown"></i> Upgrade ke Pro
                </a>
            </div>
        @else
            <button wire:click="$toggle('showCreate')" class="btn" style="margin-top:8px;background:#f4f4f4;color:#970747;font-weight:600;border:1.5px dashed #DDD6FE">
                <i class="ti ti-plus"></i> Tambah Dompet Baru
            </button>
        @endif

        {{-- CREATE FORM --}}
        @if ($showCreate)
            <div class="card" style="margin-top:10px">
                <p style="font-size:15px;font-weight:600;color:#1a1a1a;margin-bottom:14px">Dompet Baru</p>
                <div class="form-group">
                    <label class="form-label">Nama Dompet</label>
                    <input wire:model="name" type="text" placeholder="Contoh: Gopay"
                        class="form-input" style="font-size:14px">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe</label>
                    <select wire:model="type" class="form-input" style="font-size:14px">
                        <option value="cash">Uang Tunai</option>
                        <option value="bank">Rekening Bank</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>
                <button wire:click="create" class="btn btn-primary" style="background:#970747">
                    <i class="ti ti-check"></i> Simpan
                </button>
            </div>
        @endif

        {{-- TRANSFER CARD --}}
        <div class="card" style="margin-top:4px">
            <p style="font-size:15px;font-weight:600;color:#1a1a1a;margin-bottom:14px">Pindah Saldo Antar Dompet</p>
            <div class="form-group">
                <label class="form-label">Dari</label>
                <select wire:model="transferFrom" class="form-input" style="font-size:14px">
                    <option value="">Pilih dompet</option>
                    @foreach ($wallets as $w)
                        <option value="{{ $w->id }}">{{ $w->name }} (Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Ke</label>
                <select wire:model="transferTo" class="form-input" style="font-size:14px">
                    <option value="">Pilih dompet</option>
                    @foreach ($wallets as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
                @error('transferTo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah</label>
                <input wire:model="transferAmount" type="number" placeholder="Rp 0"
                    class="form-input" style="font-size:14px">
                @error('transferAmount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            @if (session('transfer_error'))
                <div class="text-xs text-red-600 bg-red-50 rounded-lg p-2 mt-2">{{ session('transfer_error') }}</div>
            @endif
            @if (session('transfer_success'))
                <div class="text-xs text-emerald-600 bg-emerald-50 rounded-lg p-2 mt-2">{{ session('transfer_success') }}</div>
            @endif
            <button wire:click="transfer" class="btn btn-primary" style="background:#970747">
                <i class="ti ti-arrows-exchange"></i> Pindahkan Saldo
            </button>
        </div>

        <div style="height:90px"></div>
    </div>

    {{-- FAB --}}
    <a href="{{ route('transaction.create') }}" class="fab" style="background:#970747;box-shadow:0 4px 16px rgba(151,4,71,.4)">
        <i class="ti ti-plus"></i>
    </a>

    {{-- BOTTOM NAV --}}
    <livewire:layouts.bottom-nav />
</div>
