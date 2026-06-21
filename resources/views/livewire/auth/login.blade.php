<div>
    <div class="bg-[#7C3AED] px-6 pt-[52px] pb-8">
        <a href="{{ route('splash') }}" class="inline-flex items-center gap-1 text-white/70 text-sm mb-4 hover:text-white transition">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <h2 class="text-[22px] font-semibold text-white">Selamat datang</h2>
        <p class="text-white/75 text-[13px] mt-1">Masuk ke buku kas keluarga Anda</p>
    </div>

    <div class="px-6 pt-7 pb-4 flex flex-col flex-1">
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="login">
            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Email</label>
                <input wire:model="email" type="email" placeholder="nama@email.com"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-[14px]">
                <label class="text-[13px] text-gray-600 mb-[5px] block">Kata Sandi</label>
                <input wire:model="password" type="password" placeholder="••••••••"
                    class="w-full px-[14px] py-3 border border-gray-300 rounded-xl text-[15px] text-gray-900 outline-none focus:border-[#7C3AED] transition @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <p class="text-right text-[13px] text-[#7C3AED] mb-6 cursor-pointer hover:underline">Lupa kata sandi?</p>

            <button type="submit" class="btn btn-primary w-full flex items-center justify-center gap-2 px-4 py-[14px] bg-[#7C3AED] text-white rounded-xl text-[15px] font-semibold cursor-pointer border-none hover:bg-[#6D28D9] transition">
                Masuk
            </button>
        </form>

        <div class="flex items-center gap-3 my-5">
            <div class="flex-1 h-[0.5px] bg-gray-200"></div>
            <span class="text-[12px] text-gray-400">atau</span>
            <div class="flex-1 h-[0.5px] bg-gray-200"></div>
        </div>

        <button class="btn btn-gray w-full flex items-center justify-center gap-2 px-4 py-[14px] bg-gray-100 text-gray-600 rounded-xl text-[15px] font-semibold cursor-pointer border-none hover:bg-gray-200 transition">
            <i class="ti ti-brand-google"></i> Masuk dengan Google
        </button>

        <p class="text-center text-[13px] text-gray-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#7C3AED] cursor-pointer hover:underline">Daftar</a>
        </p>
    </div>
</div>
