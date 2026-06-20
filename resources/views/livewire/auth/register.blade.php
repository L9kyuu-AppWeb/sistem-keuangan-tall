<div>
    <div class="bg-[#7C3AED] px-6 pt-[52px] pb-8">
        <a href="{{ route('splash') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-4 hover:text-white transition">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h2 class="text-[22px] font-semibold text-white">Buat Akun Baru</h2>
        <p class="text-white/75 text-[13px] mt-1">Gratis selamanya, upgrade kapan saja</p>
    </div>

    <div class="overflow-y-auto flex-1 px-6 pt-6 pb-[100px]">
        <form wire:submit.prevent="register">
            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Nama Lengkap</label>
                <input wire:model.live="name" type="text" placeholder="Budi Santoso"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Email</label>
                <input wire:model.live="email" type="email" placeholder="budi@email.com"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Kata Sandi</label>
                <input wire:model.live="password" type="password" placeholder="Min. 8 karakter"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Konfirmasi Kata Sandi</label>
                <input wire:model.live="password_confirmation" type="password" placeholder="Ulangi kata sandi"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition">
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-3 flex gap-2 items-start text-[13px] text-amber-800">
                <i class="ti ti-info-circle text-amber-500 text-lg shrink-0 mt-0.5"></i>
                <span>FamiBalance adalah pencatat keuangan digital. Kami tidak menyimpan data rekening bank atau memindahkan uang riil.</span>
            </div>

            <button type="submit" class="btn btn-primary w-full flex items-center justify-center gap-2 px-4 py-[14px] bg-[#7C3AED] text-white rounded-xl text-[15px] font-semibold cursor-pointer border-none hover:bg-[#6D28D9] transition mt-2">
                Buat Akun Gratis
            </button>
        </form>

        <p class="text-center text-[12px] text-gray-400 mt-[14px]">Dengan mendaftar, Anda setuju dengan Syarat & Ketentuan kami.</p>
    </div>
</div>
