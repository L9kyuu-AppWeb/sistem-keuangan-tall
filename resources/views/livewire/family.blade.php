@php
    $isPro = auth()->user()->isPro();
@endphp
<div class="page active" style="min-height:780px">
    <div class="topbar">
        <h1>Bagi Buku Keluarga</h1>
        <p>Sinkronisasi pencatatan bersama pasangan</p>
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

        {{-- Current user info card --}}
        <div class="card" style="background:#F8F5FF;border:1.5px solid #DDD6FE">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                <div class="avatar" style="background:var(--brand);width:48px;height:48px">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div style="flex:1">
                    <p style="font-size:15px;font-weight:600;color:#1a1a1a">{{ auth()->user()->name }}</p>
                    <p style="font-size:12px;color:#888">{{ $group ? 'Anda (' . (auth()->user()->family_role === 'owner' ? 'Pemilik' : 'Anggota') . ')' : 'Tidak ada grup' }}</p>
                </div>
                <span class="badge {{ $isPro ? 'badge-pro' : 'badge-free' }}">{{ $isPro ? 'Pro' : 'Free' }}</span>
            </div>

            @if (!$isPro)
                {{-- FREE: lock overlay --}}
                <div class="lock-overlay" style="position:relative;min-height:180px">
                    <div class="blur-content" style="padding:8px">
                        <div style="display:flex;gap:8px">
                            <div style="width:48px;height:48px;border-radius:12px;background:#DDD6FE"></div>
                            <div style="flex:1">
                                <div style="height:14px;background:#DDD6FE;border-radius:6px;width:60%"></div>
                                <div style="height:10px;background:#DDD6FE;border-radius:6px;width:40%;margin-top:6px"></div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:12px">
                            <div style="width:48px;height:48px;border-radius:12px;background:#DDD6FE"></div>
                            <div style="flex:1">
                                <div style="height:14px;background:#DDD6FE;border-radius:6px;width:50%"></div>
                                <div style="height:10px;background:#DDD6FE;border-radius:6px;width:35%;margin-top:6px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="lock-badge" style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(255,255,255,.8);gap:10px;padding:20px">
                        <div style="width:52px;height:52px;background:#F0EBFF;border-radius:14px;display:flex;align-items:center;justify-content:center">
                            <i class="ti ti-crown" style="font-size:26px;color:var(--brand)"></i>
                        </div>
                        <p style="font-size:15px;font-weight:600;color:#1a1a1a;text-align:center">Hubungkan Akun Pasangan</p>
                        <p style="font-size:12px;color:#888;text-align:center;line-height:1.5;padding:0 16px">
                            Catat pengeluaran bersama pasangan secara real-time dari perangkat masing-masing.
                        </p>
                        <a href="{{ route('paywall') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;border-radius:12px;padding:12px 28px;font-size:14px;font-weight:600;text-decoration:none;margin-top:4px;box-shadow:0 4px 12px rgba(151,7,71,.3)">
                            <i class="ti ti-crown" style="font-size:16px"></i> Upgrade ke Pro
                        </a>
                    </div>
                </div>
            @else
                {{-- PRO: has group --}}
                @if ($group)
                    <div style="background:#fff;border-radius:12px;padding:14px;margin-bottom:12px">
                        <p class="sec-title" style="margin-bottom:8px">Grup Aktif</p>
                        <div style="display:flex;align-items:center;gap:12px">
                            <div style="width:48px;height:48px;background:#F0EBFF;border-radius:12px;display:flex;align-items:center;justify-content:center">
                                <i class="ti ti-users" style="font-size:24px;color:var(--brand)"></i>
                            </div>
                            <div>
                                <p style="font-size:14px;font-weight:500;color:#1a1a1a">{{ $group->name }}</p>
                                <p style="font-size:12px;color:#888">Kode: <b style="color:var(--brand);letter-spacing:1px">{{ $group->code }}</b></p>
                            </div>
                        </div>
                    </div>

                    {{-- Members list --}}
                    <div style="margin-bottom:12px">
                        <p class="sec-title" style="font-size:14px;margin-bottom:8px">
                            <i class="ti ti-users" style="color:var(--brand);margin-right:4px"></i>
                            Anggota ({{ $members->count() }})
                        </p>
                        @foreach ($members as $m)
                            <div class="txn" style="padding:10px 0">
                                <div class="avatar" style="background:{{ $m->family_role === 'owner' ? 'var(--brand)' : '#6D28D9' }};width:36px;height:36px;font-size:12px">
                                    {{ strtoupper(substr($m->name, 0, 2)) }}
                                </div>
                                <div class="txn-body">
                                    <p>{{ $m->name }}</p>
                                    <span>{{ $m->family_role === 'owner' ? 'Pemilik' : 'Anggota' }} · {{ $m->email }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Shared transactions --}}
                    @if ($transactions->isNotEmpty())
                        <div style="margin-bottom:12px">
                            <p class="sec-title" style="font-size:14px;margin-bottom:8px">
                                <i class="ti ti-clock" style="color:var(--brand);margin-right:4px"></i>
                                Transaksi Terakhir (Semua Anggota)
                            </p>
                            @foreach ($transactions as $txn)
                                <div class="txn">
                                    <div class="txn-icon {{ $txn->type === 'income' ? 'in' : 'out' }}">
                                        <i class="ti ti-{{ $txn->type === 'income' ? 'arrow-down-circle' : ($txn->type === 'expense' ? 'shopping-cart' : 'arrows-exchange') }}"></i>
                                    </div>
                                    <div class="txn-body">
                                        <p>{{ $txn->description ?? 'Transaksi' }}</p>
                                        <span>{{ $txn->user->name }} · {{ $txn->date->format('d M') }}</span>
                                    </div>
                                    <div class="txn-amt {{ $txn->type === 'income' ? 'in' : 'out' }}">
                                        {{ $txn->type === 'income' ? '+' : '-' }}{{ number_format($txn->amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Leave group button --}}
                    <button wire:click="leaveGroup" onclick="return confirm('Yakin keluar dari grup?')"
                            style="width:100%;padding:12px;background:#FEF2F2;color:#EF4444;border:none;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px">
                        <i class="ti ti-logout"></i> Keluar dari Grup
                    </button>

                @else
                    {{-- PRO: no group yet, show create/join --}}
                    <div style="display:flex;flex-direction:column;gap:12px">
                        {{-- Create group --}}
                        <button wire:click="createGroup" class="btn btn-primary" style="padding:14px">
                            <i class="ti ti-plus"></i> Buat Grup Keluarga
                        </button>

                        <div style="display:flex;align-items:center;gap:12px;margin:4px 0">
                            <div style="flex:1;height:0.5px;background:#e5e5e5"></div>
                            <span style="font-size:12px;color:#aaa">atau</span>
                            <div style="flex:1;height:0.5px;background:#e5e5e5"></div>
                        </div>

                        <div style="border:1.5px dashed #DDD6FE;background:#FAFAFF;border-radius:14px;padding:18px;text-align:center">
                            <div style="width:44px;height:44px;background:#F0EBFF;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px">
                                <i class="ti ti-key" style="font-size:22px;color:var(--brand)"></i>
                            </div>
                            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin-bottom:4px">Punya Kode Grup?</p>
                            <p style="font-size:12px;color:#888;margin-bottom:14px">Masukkan 6 karakter kode dari pasangan Anda</p>
                            <div style="display:flex;gap:8px;max-width:280px;margin:0 auto">
                                <input type="text" wire:model="joinCode"
                                       style="flex:1;padding:12px 14px;border:1.5px solid #DDD6FE;border-radius:10px;font-size:18px;font-weight:700;letter-spacing:3px;text-align:center;text-transform:uppercase;color:#1a1a1a;background:#fff;outline:none;width:100%"
                                       placeholder="· · · · · ·" maxlength="6">
                            </div>
                            <button wire:click="joinGroup" class="btn btn-primary" style="margin-top:12px;padding:12px;max-width:280px;margin-left:auto;margin-right:auto">
                                <i class="ti ti-login"></i> Gabung ke Grup
                            </button>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        {{-- How it works --}}
        <div class="card">
            <p class="sec-title">Cara Kerja Family Sync</p>
            <div class="pw-feat">
                <i class="ti ti-user-plus"></i>
                <div>
                    <p>Hubungkan akun pasangan</p>
                    <span>Kirim kode unik lewat chat atau SMS</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-pencil"></i>
                <div>
                    <p>Catat dari perangkat masing-masing</p>
                    <span>Suami catat di HP-nya, istri di HP-nya</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-refresh"></i>
                <div>
                    <p>Sinkronisasi otomatis real-time</p>
                    <span>Saldo & anggaran langsung terupdate bersama</span>
                </div>
            </div>
            <div class="pw-feat">
                <i class="ti ti-chart-pie"></i>
                <div>
                    <p>Satu laporan keuangan keluarga</p>
                    <span>Tidak perlu transfer catatan manual lagi</span>
                </div>
            </div>
        </div>
    </div>
    <livewire:layouts.bottom-nav />
</div>
