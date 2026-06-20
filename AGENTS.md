# AGENTS.md

## Stack

- **Framework:** Laravel 13 (`laravel/framework: ^13.8`)
- **Frontend:** Livewire 4 (`livewire/livewire: ^4.3`) + AlpineJS
- **CSS:** Tailwind CSS 4 (`@import 'tailwindcss'` inline, no config file)
- **Build:** Vite 8 (`@tailwindcss/vite` plugin) + `laravel-vite-plugin`
- **PHP:** 8.3+
- **Database:** SQLite (default, configured in `.env`)

## App: FamiBalance

A family finance management app — track income/expenses, manage wallets, budgets, gold holdings, and family sync. Supports Free (limited) and Pro (subscription) accounts.

## Commands

| Task | Command |
|------|---------|
| Full setup (deps + key + migrate + build) | `composer setup` |
| Dev server (serve + queue + pail + vite) | `composer dev` |
| Run tests | `composer test` or `php artisan test` |
| Format PHP code | `vendor/bin/pint` |
| Create Livewire component | `php artisan make:livewire ComponentName` |

`composer test` clears config cache before running tests. Tests use in-memory SQLite.

`composer dev` uses `npx concurrently` to run four processes: `php artisan serve`, `php artisan queue:listen`, `php artisan pail`, `npm run dev`.

## Routes (web.php — all authenticated except splash/login/register)

| Route | Component | Page |
|-------|-----------|------|
| `/` | — | Splash/welcome |
| `/login` | `Auth\Login` | Login |
| `/register` | `Auth\Register` | Register |
| `/app/dashboard` | `Dashboard` | Main dashboard |
| `/app/transactions` | `Transaction\Index` | Transaction list |
| `/app/transactions/create` | `Transaction\Create` | Add transaction |
| `/app/wallets` | `Wallet\Index` | Wallet list |
| `/app/wallet/{wallet}` | `Wallet\Detail` | Single wallet detail |
| `/app/gold` | `Gold` | Gold tracking |
| `/app/budget` | `Budget` | Budget management |
| `/app/categories` | `Categories` | Custom categories |
| `/app/family` | `Family` | Family sync |
| `/app/export` | `Export` | Export CSV/Excel/PDF |
| `/app/profile` | `Profile` | User profile |
| `/app/notifications` | `Notification` | Notifications |
| `/app/change-password` | `ChangePassword` | Change password |
| `/app/help` | `Help` | Help center |
| `/app/paywall` | `Paywall` | Pro subscription |

All `app/*` routes are grouped under `Route::middleware('auth')`.

## Models

| Model | Table | Key Fields |
|-------|-------|------------|
| `User` | `users` | name, email, password, is_pro, pro_expires_at, family_group_id, family_role |
| `Category` | `categories` | name, icon, type (income/expense), is_system, user_id |
| `Wallet` | `wallets` | name, balance, icon, color, user_id |
| `Transaction` | `transactions` | type (income/expense/transfer), amount, description, date, wallet_id, category_id, user_id, wallet_to_id (transfer) |
| `Budget` | `budgets` | amount, period, category_id (nullable), user_id |
| `GoldHolding` | `gold_holdings` | weight, purchase_price, purchase_date, user_id |
| `FamilyGroup` | `family_groups` | name, code (6-char unique joining code) |
| `UserNotification` | `notifications` | type, title, message, read_at, user_id |

### Conventions

- Models use PHP 8.3 attributes `#[Fillable]` and `#[Hidden]` (see `User.php`).
- `isPro()` method on User checks `is_pro && (!pro_expires_at || pro_expires_at->isFuture())`.

## Livewire Components (18 total)

All full-page components (extend `Component`, use `->layout('layouts.app')`), except:

- `Auth\Login` / `Auth\Register` — layout `layouts.guest`
- `Layouts\BottomNav` — invoked as `@livewire('layouts.bottom-nav')` in dashboard

## Design System

- **Brand color:** `#970747` (maroon) — CSS variable `--brand`
- **Layout:** Phone mockup wrapper (`.phone`, max-width 390px, rounded-3xl)
- **Icons:** Tabler Icons CDN (`ti ti-*`)
- **Font:** Instrument Sans via `@fonts` directive (Vite bunny CDN)
- **CSS:** Tailwind CSS 4 + custom classes in `resources/css/app.css`:
  - `.phone`, `.page`, `.scroll-area` — layout
  - `.topbar` — header bar (brand bg)
  - `.card`, `.card-brand` — content cards
  - `.prog-wrap`, `.prog-bar`, `.prog-fill` — progress bars
  - `.txn`, `.txn-icon`, `.txn-body` — transaction/category rows
  - `.nav-pill`, `.nav-item` — bottom navigation
  - `.btn`, `.btn-primary` — buttons
  - `.stat-row`, `.stat` — stat counters
  - `.badge` — status badges
  - `.tip` — info/tips boxes
  - `.lock-overlay`, `.lock-badge`, `.blur-content` — Pro feature gating
  - `.form-label`, `.form-input` — form elements

## Authentication & Subscription

- **Free:** 2 wallets max, system categories only, general budget, no export
- **Pro:** unlimited wallets, custom categories, budget per category, family sync, export (CSV/Excel/PDF)
- `User::isPro()`: `is_pro && (!pro_expires_at || pro_expires_at->isFuture())`
- Test accounts: `budi@email.com` (FREE), `pro@famibalance.com` (PRO, exp 2027-06-20)
- Both passwords: `password123` (migrated hashed)

## UI Patterns

- Halaman diakses dari menu Profile → tombol "Kembali" arah ke Profile, bukan Dashboard
- Pro features show badge "Pro" (amber) on menu items for free users
- Pro features use `.lock-overlay` + `.lock-badge` blur overlay with upgrade button
- Bottom nav: 5 tabs — Beranda (`ti-home`), Dompet (`ti-wallet`), Emas (`ti-star`), Keluarga (`ti-users`), Profil (`ti-user-circle`)
- Layouts: `layouts.app` (auth pages), `layouts.guest` (login/register)

## Testing

- PHPUnit 12 with in-memory SQLite (configured in `phpunit.xml`)
- Feature tests extend `Tests\TestCase`, unit tests extend `PHPUnit\Framework\TestCase`
- `RefreshDatabase` trait available but commented out
- Pulse, Telescope, Nightwatch disabled in test env
- 3 test files: `Feature/ExampleTest.php`, `Unit/ExampleTest.php`, `TestCase.php`
- `phpunit.xml` sets `APP_ENV=testing`, `CACHE_STORE=array`, `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`

## Code Style

- Laravel Pint (PSR-12/Laravel) — run `vendor/bin/pint` before committing
- Indentation: 4 spaces, LF line endings (`.editorconfig`)
- `.gitattributes`: `* text=auto eol=lf`

## Gotchas

- `.npmrc` sets `ignore-scripts=true`. `composer setup` passes `--ignore-scripts` to `npm install`.
- Vite watch ignores `storage/framework/views/**`.
- No CI/CD workflows or Docker config exist.
- `bootstrap/app.php` configures routing + exception handling directly (no HTTP Kernel).
- Tailwind CSS 4 uses `@import 'tailwindcss'` + `@source` directives — no `tailwind.config.*` file.
- Vite fonts handled via `laravel-vite-plugin`'s `fonts` option with `bunny()`.
- `APP_URL` in `.env` uses ngrok tunnel for gateway/mobile testing.
- No `maatwebsite/excel` or `dompdf` installed — exports use native PHP.
