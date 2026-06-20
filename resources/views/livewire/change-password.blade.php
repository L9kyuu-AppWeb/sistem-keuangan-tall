<div class="page active" style="min-height:780px">
    <div class="topbar">
        <a href="{{ route('profile') }}" style="background:none;border:none;color:rgba(255,255,255,.7);font-size:14px;cursor:pointer;margin-bottom:12px;display:flex;align-items:center;gap:4px">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h1>Ubah Kata Sandi</h1>
    </div>

    <div class="scroll-area" style="padding-top:16px">
        @if (session('success'))
            <div class="tip" style="background:#ECFDF5;border-color:#A7F3D0;color:#065F46;margin-bottom:12px">
                <i class="ti ti-check-circle" style="color:#059669"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="tip" style="background:#FEF2F2;border-color:#FECACA;color:#991B1B;margin-bottom:12px">
                <i class="ti ti-alert-circle" style="color:#EF4444"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="card">
            <div style="text-align:center;margin-bottom:20px">
                <div style="width:56px;height:56px;background:#F0EBFF;border-radius:16px;display:inline-flex;align-items:center;justify-content:center">
                    <i class="ti ti-lock" style="font-size:28px;color:var(--brand)"></i>
                </div>
                <p style="font-size:14px;color:#888;margin-top:8px">Masukkan password lama dan password baru Anda</p>
            </div>

            <div style="margin-bottom:16px">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" wire:model="current_password" class="form-input" placeholder="••••••••">
                @error('current_password')
                    <p style="font-size:11px;color:#EF4444;margin-top:4px">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom:16px">
                <label class="form-label">Password Baru</label>
                <input type="password" wire:model="password" class="form-input" placeholder="Minimal 8 karakter">
                @error('password')
                    <p style="font-size:11px;color:#EF4444;margin-top:4px">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom:20px">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" wire:model="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                @error('password_confirmation')
                    <p style="font-size:11px;color:#EF4444;margin-top:4px">{{ $message }}</p>
                @enderror
            </div>

            <button wire:click="save" class="btn btn-primary">
                <i class="ti ti-device-floppy"></i> Simpan Password
            </button>
        </div>

        <div class="tip" style="margin-top:8px">
            <i class="ti ti-info-circle" style="color:var(--brand);flex-shrink:0"></i>
            <span>Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol untuk keamanan akun Anda.</span>
        </div>
    </div>
</div>
