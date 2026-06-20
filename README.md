# 💰 FamiBalance

Aplikasi manajemen keuangan keluarga berbasis web dengan tampilan mobile-first. Kelola transaksi, dompet, budget, investasi emas, dan sync data bersama pasangan — semua dari satu aplikasi.

## 🚀 Tech Stack

| Layer | Tech |
|-------|------|
| Backend | Laravel 13 + PHP 8.3+ |
| Frontend | Livewire 4 + AlpineJS |
| Styling | Tailwind CSS 4 + custom design system |
| Build | Vite 8 + laravel-vite-plugin |
| Database | SQLite (default) |
| Icons | [Tabler Icons](https://tabler.io/icons) (CDN) |
| Font | Instrument Sans (via Bunny CDN) |

## 📱 Fitur Utama

### Free Account
- ✅ Dashboard ringkasan keuangan
- ✅ Pencatatan transaksi (pemasukan / pengeluaran / transfer)
- ✅ Multi dompet (maks. 2)
- ✅ Anggaran bulanan umum
- ✅ 23+ kategori default (sistem)
- ✅ Notifikasi transaksi

### Pro Account
- ✅ Semua fitur Free
- ✅ Dompet unlimited
- ✅ Kategori kustom tak terbatas
- ✅ Multi-anggaran per kategori
- ✅ Family Sync — bagi buku dengan pasangan
- ✅ Pelacakan investasi emas (emas.com)
- ✅ Ekspor data ke CSV, Excel & PDF
- ✅ Riwayat bulanan

## 🏗️ Struktur Aplikasi

### Halaman & Route

| Route | Halaman |
|-------|---------|
| `/` | Splash / Welcome |
| `/login` | Login |
| `/register` | Register |
| `/app/dashboard` | Dashboard utama |
| `/app/transactions` | Daftar transaksi |
| `/app/transactions/create` | Tambah transaksi |
| `/app/wallets` | Daftar dompet |
| `/app/wallet/{id}` | Detail dompet + riwayat |
| `/app/gold` | Emas (emas.com) |
| `/app/budget` | Anggaran bulanan |
| `/app/categories` | Kelola kategori (Pro) |
| `/app/family` | Family Sync (Pro) |
| `/app/export` | Ekspor data (Pro) |
| `/app/profile` | Profil akun |
| `/app/notifications` | Notifikasi |
| `/app/change-password` | Ubah kata sandi |
| `/app/help` | Pusat bantuan |
| `/app/paywall` | Upgrade ke Pro |

### Database (8 tables)

| Tabel | Fungsi |
|-------|--------|
| `users` | Akun user (name, email, password, is_pro, family_group_id, family_role) |
| `categories` | Kategori transaksi (income/expense, system/custom) |
| `wallets` | Dompet (name, balance, icon, color) |
| `transactions` | Transaksi (type: income/expense/transfer, amount, date, wallet, category) |
| `budgets` | Anggaran per kategori / umum (amount, period) |
| `gold_holdings` | Investasi emas (weight, purchase_price, date) |
| `family_groups` | Grup keluarga (name, code) |
| `notifications` | Notifikasi user (type, title, message, read_at) |

## 🎨 Design System

- **Brand Color:** `#970747` (maroon)
- **Layout:** Mobile-first phone mockup (max-width 390px, rounded corners)
- **Icons:** Tabler Icons (`ti ti-*`) via CDN
- **Font:** Instrument Sans 400/500/600
- **Pattern:** Topbar branded → scrollable content → bottom navigation (5 tabs)

### CSS Classes Kustom

| Class | Fungsi |
|-------|--------|
| `.phone` | Phone frame wrapper (max 390px, rounded-3xl) |
| `.topbar` | Header bar dengan background brand |
| `.card` / `.card-brand` | Content card (putih / ungu gradient) |
| `.txn` / `.txn-icon` / `.txn-body` | Transaction row layout |
| `.prog-bar` / `.prog-fill` | Progress bar |
| `.nav-pill` / `.nav-item` | Bottom navigation |
| `.btn` / `.btn-primary` | Button styles |
| `.lock-overlay` / `.lock-badge` | Pro feature lock overlay |
| `.stat-row` / `.stat` | Statistic counter |

### Bottom Navigation (5 tabs)

| Tab | Icon | Route |
|-----|------|-------|
| Beranda | `ti-home` | Dashboard |
| Dompet | `ti-wallet` | Wallets |
| Emas | `ti-star` | Gold |
| Keluarga | `ti-users` | Family |
| Profil | `ti-user-circle` | Profile |

## ⚙️ Setup

### Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+
- npm

### Installation

```bash
# Clone repo
git clone <repo-url>
cd sistem-keuangan-tall

# Full setup (deps + key + migrate + build)
composer setup
```

### Development

```bash
# Start dev server (server + queue + logs + vite)
composer dev
```

### Commands

| Task | Command |
|------|---------|
| Full setup | `composer setup` |
| Dev server | `composer dev` |
| Run tests | `composer test` |
| Format code | `vendor/bin/pint` |
| Clear view cache | `php artisan view:clear` |
| Create component | `php artisan make:livewire ComponentName` |
| List routes | `php artisan route:list` |
| Tinker (DB shell) | `php artisan tinker` |

## 🧪 Testing

```bash
composer test        # clears config cache + runs tests
php artisan test     # direct run (PHPUnit 12)
```

- Database: in-memory SQLite (otomatis, dari `phpunit.xml`)
- Pulse, Telescope, Nightwatch: disabled di test env
- Feature tests extend `Tests\TestCase`
- Unit tests extend `PHPUnit\Framework\TestCase`

## 🔐 Test Accounts

| Email | Password | Status |
|-------|----------|--------|
| `budi@email.com` | `password123` | FREE |
| `pro@famibalance.com` | `password123` | PRO (exp 2027-06-20) |

## 📂 Project Structure

```
sistem-keuangan-tall/
├── app/
│   ├── Livewire/                 # 18 Livewire components
│   │   ├── Auth/                 # Login, Register
│   │   ├── Layouts/              # BottomNav
│   │   ├── Transaction/          # Create, Index
│   │   ├── Wallet/               # Index, Detail
│   │   ├── Budget.php            # Anggaran bulanan
│   │   ├── Categories.php        # Kategori kustom (Pro)
│   │   ├── Export.php            # Export CSV/Excel/PDF (Pro)
│   │   ├── Family.php            # Family Sync (Pro)
│   │   ├── Gold.php              # Emas tracking
│   │   ├── Profile.php           # Profil akun
│   │   ├── ChangePassword.php    # Ubah password
│   │   ├── Notification.php      # Notifikasi
│   │   ├── Help.php              # Pusat bantuan
│   │   ├── Paywall.php           # Halaman upgrade
│   │   └── Dashboard.php         # Dashboard utama
│   └── Models/                   # 8 Eloquent models
│       ├── User.php              # with isPro(), #[Fillable]
│       ├── Category.php          # system + custom categories
│       ├── Wallet.php            # wallet + balance
│       ├── Transaction.php       # income/expense/transfer
│       ├── Budget.php            # per-kategori budget
│       ├── GoldHolding.php       # emas investment
│       ├── FamilyGroup.php       # family sync group
│       └── UserNotification.php  # notifications
├── resources/
│   ├── css/app.css               # Tailwind CSS 4 + design system
│   ├── js/app.js                 # AlpineJS
│   └── views/
│       ├── layouts/              # app.blade.php, guest.blade.php
│       └── livewire/             # 20 Blade views
├── database/
│   └── migrations/               # 11 migration files
├── routes/
│   ├── web.php                   # 18 routes (auth + guest)
│   └── console.php               # artisan inspire
├── bootstrap/app.php             # Laravel 13 config (no HTTP Kernel)
├── composer.json                 # Laravel 13, Livewire 4, Tinker
├── package.json                  # Vite 8, Tailwind CSS 4, concurrently
├── vite.config.js                # fonts: bunny, watch ignores views
├── phpunit.xml                   # in-memory SQLite, disabled services
├── .editorconfig                 # 4 spaces, LF
├── .gitattributes                # eol=lf
├── .npmrc                        # ignore-scripts=true
└── AGENTS.md                     # Project context for AI agents
```

## 📝 Code Conventions

- **Models:** PHP 8.3 attributes `#[Fillable]` dan `#[Hidden]` (bukan `$fillable` property)
- **Tailwind CSS 4:** `@import 'tailwindcss'` (bukan v3 `@tailwind` directives)
- **Code style:** Laravel Pint (PSR-12/Laravel) — run sebelum commit
- **Indentation:** 4 spaces, LF line endings
- **Routing:** Semua di `routes/web.php`, config di `bootstrap/app.php` (no HTTP Kernel)
- **Branding:** Warn `#970747` maroon di semua halaman

## 🔧 Known Gotchas

- `.npmrc` sets `ignore-scripts=true` — `composer setup` passes `--ignore-scripts` ke npm
- Vite watch mengabaikan `storage/framework/views/**` (compiled Blade views)
- Tidak ada CI/CD workflow atau Docker config
- Tailwind CSS 4 tidak pakai `tailwind.config.*` — theme di `@theme` block di `app.css`
- Tidak ada `maatwebsite/excel` atau `dompdf` — export pakai native PHP
- `APP_URL` di `.env` pakai ngrok tunnel untuk mobile/gateway testing

## 📄 License

MIT
