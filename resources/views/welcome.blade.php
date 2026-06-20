<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FamiBalance</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        .pw-bg { background: #7C3AED; }
        .pw-icon { width: 80px; height: 80px; background: rgba(255,255,255,.2); border-radius: 24px; display: flex; align-items: center; justify-content: center; }
        .pw-icon i { font-size: 44px; color: #fff; }
    </style>
</head>
<body class="pw-bg flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm text-center px-8">
        <div class="pw-icon mx-auto">
            <i class="ti ti-home-heart"></i>
        </div>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-white mb-1.5">FamiBalance</h1>
            <p class="text-white/75 text-base">Buku kas digital keluarga Anda</p>
        </div>
        <div class="mt-8 flex flex-col gap-2.5">
            <a href="{{ route('login') }}" class="block text-center bg-white text-purple-600 font-bold text-sm py-3.5 rounded-xl">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="block text-center text-white font-bold text-sm py-3.5 rounded-xl border-[1.5px] border-white/50 bg-transparent">
                Daftar Gratis
            </a>
        </div>
        <p class="text-white/45 text-[11px] mt-5">Bukan aplikasi transfer atau perbankan</p>
    </div>
</body>
</html>
