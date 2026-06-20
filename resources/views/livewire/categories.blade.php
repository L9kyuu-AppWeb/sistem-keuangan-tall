@php
    $iconList = ['shopping-cart','bolt','soup','car','device-tv','heart-rate-monitor','school','dots','tag','wallet','star','users','trending-up','piggy-bank','home','briefcase','gift','plane','music','phone','coffee','dumbbell','baby','film','cake','book','palette','wrench','scissors','plant','globe','shield','bell','clock','map-pin','camera','brush','headphones','heart','leaf','zap','droplet','sun','moon'];
@endphp
<div class="page active" style="min-height:780px">
    <div class="topbar">
        <a href="{{ route('profile') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;gap:4px">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h1>Kategori</h1>
        <p>Kelola kategori pengeluaran & pemasukan</p>
    </div>

    <div class="scroll-area" style="padding-top:16px">
        @if (session('success'))
            <div class="tip" style="background:#ECFDF5;border-color:#A7F3D0;color:#065F46">
                <i class="ti ti-check-circle" style="color:#059669"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="tip" style="background:#FEF2F2;border-color:#FECACA;color:#991B1B">
                <i class="ti ti-alert-circle" style="color:#EF4444"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Add button / Form --}}
        @if ($showForm)
            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
                    <p class="sec-title" style="margin:0">{{ $editingId ? 'Edit' : 'Tambah' }} Kategori</p>
                    <button wire:click="resetForm" style="background:none;border:none;color:#888;font-size:20px;cursor:pointer;line-height:1">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" wire:model="name" class="form-input" placeholder="Contoh: Gaji, THR, Donasi...">
                    @error('name') <p style="font-size:11px;color:#EF4444;margin-top:4px">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <div style="display:grid;grid-template-columns:repeat(8,1fr);gap:6px">
                        @foreach ($iconList as $ic)
                            <button wire:click="$set('icon', '{{ $ic }}')"
                                    class="cat-btn {{ $icon === $ic ? 'on' : '' }}"
                                    style="padding:8px 2px">
                                <i class="ti ti-{{ $ic }}"></i>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div style="display:flex;gap:8px;margin-top:8px">
                    <button wire:click="resetForm" class="btn btn-gray" style="flex:1;padding:12px">Batal</button>
                    <button wire:click="save" class="btn btn-primary" style="flex:1;padding:12px">
                        {{ $editingId ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        @else
            @if (auth()->user()->isPro())
                <button wire:click="startAdd" class="btn btn-outline" style="margin-bottom:12px;padding:12px">
                    <i class="ti ti-plus"></i> Tambah Kategori Baru
                </button>
            @else
                <div class="lock-overlay" style="margin-bottom:12px">
                    <div class="blur-content" style="padding:8px">
                        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:6px">
                            <div class="cat-btn on"><i class="ti ti-shopping-cart"></i><span>Belanja</span></div>
                            <div class="cat-btn on"><i class="ti ti-bolt"></i><span>Tagihan</span></div>
                            <div class="cat-btn on"><i class="ti ti-soup"></i><span>Makan</span></div>
                            <div class="cat-btn on"><i class="ti ti-car"></i><span>Transport</span></div>
                        </div>
                    </div>
                    <div class="lock-badge">
                        <i class="ti ti-crown"></i>
                        <p>Kategori Kustom untuk Pro</p>
                        <a href="{{ route('paywall') }}" class="btn btn-primary" style="width:auto;padding:10px 20px;font-size:13px;text-decoration:none">Upgrade Pro</a>
                    </div>
                </div>
            @endif
        @endif

        {{-- Category list --}}
        @foreach ($categories as $cat)
            <div class="txn" style="padding:12px 0">
                <div class="txn-icon budget">
                    <i class="ti ti-{{ $cat->icon }}"></i>
                </div>
                <div class="txn-body">
                    <p style="font-size:14px">{{ $cat->name }}</p>
                    <span style="font-size:11px">
                        @if ($cat->is_system)
                            Kategori sistem
                        @else
                            Kategori kustom
                        @endif
                    </span>
                </div>
                @if (!$cat->is_system && auth()->user()->isPro())
                    <div style="display:flex;gap:4px;flex-shrink:0">
                        <button wire:click="startEdit({{ $cat->id }})"
                                style="background:none;border:none;color:var(--brand);cursor:pointer;padding:6px;font-size:16px">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button wire:click="delete({{ $cat->id }})"
                                onclick="return confirm('Hapus kategori ini?')"
                                style="background:none;border:none;color:#EF4444;cursor:pointer;padding:6px;font-size:16px">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach

        @if ($categories->isEmpty())
            <div style="text-align:center;padding:32px 0">
                <i class="ti ti-tag" style="font-size:40px;color:#ddd"></i>
                <p style="color:#888;font-size:13px;margin-top:8px">Belum ada kategori.</p>
            </div>
        @endif

        <div class="tip" style="margin-top:12px">
            <i class="ti ti-bulb"></i>
            <span><b>Tips:</b> Kategori kustom bisa dipakai di transaksi dan budget per kategori.</span>
        </div>
    </div>
</div>
