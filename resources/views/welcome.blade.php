<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FamiBalance - Buku Kas Digital Keluarga</title>
    <meta name="description" content="Aplikasi pencatatan keuangan keluarga. Kelola dompet, anggaran, emas, dan sinkronisasi dengan pasangan.">
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;min-height:100vh;background:#f8f6f7}
        .brand-bg{background:#970747}
        .brand-text{color:#970747}
        .brand-border{border-color:#970747}
        @media(max-width:640px){
            .hide-mobile{display:none!important}
        }
        .fade-up{animation:fadeUp .6s ease-out forwards;opacity:0}
        .fade-up-1{animation-delay:.1s}
        .fade-up-2{animation-delay:.2s}
        .fade-up-3{animation-delay:.3s}
        .fade-up-4{animation-delay:.4s}
        @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
    </style>
</head>
<body>
<div style="max-width:430px;margin:0 auto;min-height:100vh;background:#fff;box-shadow:0 0 40px rgba(0,0,0,.06)">

{{-- HERO --}}
<section style="background:#970747;padding:48px 20px 60px;text-align:center;position:relative;overflow:hidden">
    {{-- decorative circles --}}
    <div style="position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04)"></div>
    <div style="position:absolute;bottom:-40px;left:-40px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.04)"></div>

    <div style="width:80px;height:80px;background:rgba(255,255,255,.2);border-radius:24px;display:flex;align-items:center;justify-content:center;margin:0 auto" class="fade-up fade-up-1">
        <i class="ti ti-home-heart" style="font-size:44px;color:#fff"></i>
    </div>
    <h1 style="font-size:32px;font-weight:800;color:#fff;margin-top:16px" class="fade-up fade-up-2">FamiBalance</h1>
    <p style="color:rgba(255,255,255,.8);font-size:16px;margin-top:6px;max-width:300px;margin-left:auto;margin-right:auto" class="fade-up fade-up-3">
        Buku kas digital keluarga — catat, pantau, dan kendalikan keuangan rumah tangga dengan mudah.
    </p>

    <div style="margin-top:28px;display:flex;flex-direction:column;gap:10px;max-width:320px;margin-left:auto;margin-right:auto" class="fade-up fade-up-4">
        <a href="{{ route('login') }}"
            style="display:block;width:100%;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#fff;color:#970747;text-decoration:none">
            <i class="ti ti-login" style="font-size:16px;vertical-align:middle;margin-right:6px"></i> Masuk
        </a>
        <a href="{{ route('register') }}"
            style="display:block;width:100%;padding:14px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:1.5px solid rgba(255,255,255,.5);background:transparent;color:#fff;text-decoration:none">
            <i class="ti ti-user-plus" style="font-size:16px;vertical-align:middle;margin-right:6px"></i> Daftar Gratis
        </a>
    </div>

    {{-- stats bar --}}
    <div style="margin-top:32px;display:flex;gap:0;max-width:360px;margin-left:auto;margin-right:auto;background:rgba(255,255,255,.08);border-radius:16px;padding:16px 12px;backdrop-filter:blur(4px)">
        <div style="flex:1;text-align:center;border-right:1px solid rgba(255,255,255,.15)">
            <p style="font-size:20px;font-weight:700;color:#fff">100%</p>
            <p style="font-size:10px;color:rgba(255,255,255,.6);margin-top:2px">Gratis Daftar</p>
        </div>
        <div style="flex:1;text-align:center;border-right:1px solid rgba(255,255,255,.15)">
            <p style="font-size:20px;font-weight:700;color:#fff">Free</p>
            <p style="font-size:10px;color:rgba(255,255,255,.6);margin-top:2px">Tanpa Kartu</p>
        </div>
        <div style="flex:1;text-align:center">
            <p style="font-size:20px;font-weight:700;color:#fff">Pro</p>
            <p style="font-size:10px;color:rgba(255,255,255,.6);margin-top:2px">Mulai Rp29rb</p>
        </div>
    </div>
</section>

{{-- FITUR --}}
<section style="padding:40px 20px">
    <h2 style="font-size:22px;font-weight:700;color:#1a1a1a;text-align:center;margin-bottom:6px">Kenapa FamiBalance?</h2>
    <p style="font-size:14px;color:#888;text-align:center;max-width:300px;margin:0 auto 28px">Aplikasi pencatatan keuangan rumah tangga #1 di Indonesia — mobile-first, mudah, dan aman.</p>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;max-width:400px;margin:0 auto">
        {{-- fitur 1 --}}
        <div style="background:#fff;border-radius:16px;padding:18px 14px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.04)">
            <div style="width:44px;height:44px;background:#FDF2F8;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                <i class="ti ti-wallet" style="font-size:22px;color:#970747"></i>
            </div>
            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin-top:10px">Dompet Virtual</p>
            <p style="font-size:11px;color:#888;margin-top:4px;line-height:1.5">Kelola banyak pos saldo: tunai, bank, e-wallet</p>
        </div>

        {{-- fitur 2 --}}
        <div style="background:#fff;border-radius:16px;padding:18px 14px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.04)">
            <div style="width:44px;height:44px;background:#FDF2F8;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                <i class="ti ti-chart-pie" style="font-size:22px;color:#970747"></i>
            </div>
            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin-top:10px">Anggaran</p>
            <p style="font-size:11px;color:#888;margin-top:4px;line-height:1.5">Pantau pemasukan & pengeluaran bulanan</p>
        </div>

        {{-- fitur 3 --}}
        <div style="background:#fff;border-radius:16px;padding:18px 14px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.04)">
            <div style="width:44px;height:44px;background:#FDF2F8;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                <i class="ti ti-star" style="font-size:22px;color:#970747"></i>
            </div>
            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin-top:10px">Dompet Emas</p>
            <p style="font-size:11px;color:#888;margin-top:4px;line-height:1.5">Lacak portofolio emas dengan nilai real-time</p>
        </div>

        {{-- fitur 4 --}}
        <div style="background:#fff;border-radius:16px;padding:18px 14px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.04)">
            <div style="width:44px;height:44px;background:#FDF2F8;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto">
                <i class="ti ti-users" style="font-size:22px;color:#970747"></i>
            </div>
            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin-top:10px">Family Sync</p>
            <p style="font-size:11px;color:#888;margin-top:4px;line-height:1.5">Catat bareng pasangan, sinkron real-time</p>
        </div>
    </div>
</section>

{{-- BAGIAN CARA KERJA --}}
<section style="padding:32px 20px;background:#fff">
    <h2 style="font-size:20px;font-weight:700;color:#1a1a1a;text-align:center;margin-bottom:24px">Cara Kerja</h2>

    <div style="max-width:380px;margin:0 auto">
        <div style="display:flex;gap:16px;margin-bottom:20px">
            <div style="width:36px;height:36px;background:#970747;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <span style="color:#fff;font-weight:700;font-size:14px">1</span>
            </div>
            <div>
                <p style="font-size:15px;font-weight:600;color:#1a1a1a">Daftar Gratis</p>
                <p style="font-size:13px;color:#888;margin-top:2px">Buat akun tanpa kartu kredit. Langsung bisa digunakan.</p>
            </div>
        </div>
        <div style="display:flex;gap:16px;margin-bottom:20px">
            <div style="width:36px;height:36px;background:#970747;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <span style="color:#fff;font-weight:700;font-size:14px">2</span>
            </div>
            <div>
                <p style="font-size:15px;font-weight:600;color:#1a1a1a">Catat Transaksi</p>
                <p style="font-size:13px;color:#888;margin-top:2px">Input pemasukan & pengeluaran harian di dompet virtual Anda.</p>
            </div>
        </div>
        <div style="display:flex;gap:16px">
            <div style="width:36px;height:36px;background:#970747;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <span style="color:#fff;font-weight:700;font-size:14px">3</span>
            </div>
            <div>
                <p style="font-size:15px;font-weight:600;color:#1a1a1a">Pantau & Evaluasi</p>
                <p style="font-size:13px;color:#888;margin-top:2px">Lihat laporan, anggaran, dan analisis keuangan keluarga.</p>
            </div>
        </div>
    </div>
</section>

{{-- FREE VS PRO --}}
<section style="padding:40px 20px">
    <h2 style="font-size:20px;font-weight:700;color:#1a1a1a;text-align:center;margin-bottom:6px">Free vs Pro</h2>
    <p style="font-size:13px;color:#888;text-align:center;margin-bottom:24px">Mulai gratis, upgrade kapan saja</p>

    <div style="max-width:380px;margin:0 auto;display:grid;gap:12px">
        {{-- row 1 --}}
        <div style="background:#fff;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 3px rgba(0,0,0,.03)">
            <i class="ti ti-wallet" style="font-size:20px;color:#970747;flex-shrink:0"></i>
            <div style="flex:1">
                <p style="font-size:13px;font-weight:500;color:#1a1a1a">Dompet Virtual</p>
            </div>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#F3F4F6;color:#6B7280">Free: 2</span>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#FDF2F8;color:#970747">Pro: ∞</span>
        </div>

        {{-- row 2 --}}
        <div style="background:#fff;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 3px rgba(0,0,0,.03)">
            <i class="ti ti-star" style="font-size:20px;color:#970747;flex-shrink:0"></i>
            <div style="flex:1">
                <p style="font-size:13px;font-weight:500;color:#1a1a1a">Dompet Emas</p>
            </div>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#F3F4F6;color:#6B7280">Statis</span>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#FDF2F8;color:#970747">Real-time</span>
        </div>

        {{-- row 3 --}}
        <div style="background:#fff;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 3px rgba(0,0,0,.03)">
            <i class="ti ti-users" style="font-size:20px;color:#970747;flex-shrink:0"></i>
            <div style="flex:1">
                <p style="font-size:13px;font-weight:500;color:#1a1a1a">Family Sync</p>
            </div>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#F3F4F6;color:#6B7280">Single</span>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#FDF2F8;color:#970747">Multi</span>
        </div>

        {{-- row 4 --}}
        <div style="background:#fff;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 3px rgba(0,0,0,.03)">
            <i class="ti ti-chart-pie" style="font-size:20px;color:#970747;flex-shrink:0"></i>
            <div style="flex:1">
                <p style="font-size:13px;font-weight:500;color:#1a1a1a">Anggaran</p>
            </div>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#F3F4F6;color:#6B7280">1 per bulan</span>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#FDF2F8;color:#970747">Multi-kategori</span>
        </div>

        {{-- row 5 --}}
        <div style="background:#fff;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 1px 3px rgba(0,0,0,.03)">
            <i class="ti ti-download" style="font-size:20px;color:#970747;flex-shrink:0"></i>
            <div style="flex:1">
                <p style="font-size:13px;font-weight:500;color:#1a1a1a">Ekspor Data</p>
            </div>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#F3F4F6;color:#6B7280">—</span>
            <span style="font-size:11px;padding:2px 8px;border-radius:10px;font-weight:600;background:#FDF2F8;color:#970747">Excel/CSV/PDF</span>
        </div>
    </div>

    <div style="text-align:center;margin-top:20px">
        <a href="{{ route('register') }}"
            style="display:inline-block;padding:14px 28px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#970747;color:#fff;text-decoration:none">
            <i class="ti ti-rocket" style="font-size:16px;vertical-align:middle;margin-right:6px"></i> Mulai Gratis Sekarang
        </a>
        <p style="font-size:11px;color:#aaa;margin-top:10px">Tanpa komitmen. Upgrade kapan saja.</p>
    </div>
</section>

{{-- TESTIMONI --}}
<section style="padding:32px 20px;background:linear-gradient(180deg,#970747 0%,#7a0539 100%);color:#fff">
    <h2 style="font-size:20px;font-weight:700;text-align:center;margin-bottom:4px">Yang Mereka Katakan</h2>
    <p style="font-size:13px;text-align:center;opacity:.75;margin-bottom:24px">Sudah dipakai ribuan keluarga di Indonesia</p>

    <div style="max-width:360px;margin:0 auto;display:grid;gap:12px">
        <div style="background:rgba(255,255,255,.12);border-radius:14px;padding:16px">
            <div style="display:flex;gap:3px;margin-bottom:8px">
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
            </div>
            <p style="font-size:13px;line-height:1.6;opacity:.9">"Akhirnya ada aplikasi yang simpel buat catat keuangan rumah tangga. Istri saya juga bisa ikut lihat!"</p>
            <p style="font-size:12px;font-weight:600;margin-top:8px;opacity:.8">— Andi, Jakarta</p>
        </div>
        <div style="background:rgba(255,255,255,.12);border-radius:14px;padding:16px">
            <div style="display:flex;gap:3px;margin-bottom:8px">
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
                <i class="ti ti-star-filled" style="font-size:14px;color:#FCD34D"></i>
            </div>
            <p style="font-size:13px;line-height:1.6;opacity:.9">"Fitur emasnya bantu banget buat pantau investasi. Saya bisa lihat gain/loss real-time."</p>
            <p style="font-size:12px;font-weight:600;margin-top:8px;opacity:.8">— Sari, Bandung</p>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section style="padding:40px 20px;text-align:center">
    <div style="width:56px;height:56px;background:#FDF2F8;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto">
        <i class="ti ti-home-heart" style="font-size:28px;color:#970747"></i>
    </div>
    <h2 style="font-size:20px;font-weight:700;color:#1a1a1a;margin-top:12px">Siap Kelola Keuangan Keluarga?</h2>
    <p style="font-size:14px;color:#888;margin-top:6px;max-width:280px;margin-left:auto;margin-right:auto">Gratis selamanya untuk kebutuhan dasar. Upgrade Pro untuk fitur lengkap.</p>
    <a href="{{ route('register') }}"
        style="display:inline-block;margin-top:20px;padding:14px 32px;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;border:none;background:#970747;color:#fff;text-decoration:none">
        <i class="ti ti-rocket"></i> Daftar Gratis
    </a>
</section>

{{-- FOOTER --}}
<footer style="padding:24px 20px;text-align:center;border-top:0.5px solid #e5e5e5">
    <div style="display:flex;justify-content:center;gap:16px;margin-bottom:12px">
        <a href="{{ route('login') }}" style="font-size:12px;color:#888;text-decoration:none">Masuk</a>
        <a href="{{ route('register') }}" style="font-size:12px;color:#888;text-decoration:none">Daftar</a>
    </div>
    <p style="font-size:11px;color:#aaa">FamiBalance — Buku kas digital untuk keluarga Indonesia.</p>
    <p style="font-size:10px;color:#bbb;margin-top:4px">Bukan aplikasi transfer atau perbankan. Kami tidak memindahkan uang riil.</p>
    <p style="font-size:10px;color:#bbb;margin-top:8px">© {{ date('Y') }} FamiBalance. All rights reserved.</p>
</footer>

</div>
</body>
</html>
