# AGENTS.md

## Stack

Laravel 13 + Livewire 4 + Tailwind CSS 4 + AlpineJS + Vite. PHP 8.3+ required. SQLite default database.

## Commands

| Task | Command |
|------|---------|
| Full setup (deps + key + migrate + build) | `composer setup` |
| Dev server (serve + queue + pail + vite) | `composer dev` |
| Run tests | `composer test` or `php artisan test` |
| Format PHP code | `vendor/bin/pint` |
| Create Livewire component | `php artisan make:livewire ComponentName` |

`composer test` clears config cache before running tests. Tests use in-memory SQLite (configured in `phpunit.xml`).

`composer dev` uses `npx concurrently` to run four processes: server, queue, logs, vite.

## Conventions

- **Models**: Use PHP 8.3 attributes for `#[Fillable]` and `#[Hidden]` instead of `$fillable`/`$hidden` properties. See `app/Models/User.php`.
- **Tailwind CSS 4**: Uses `@import 'tailwindcss'` (not v3's `@tailwind` directives). Content scanning via `@source`. Theme customization in `@theme` block. Configured in `resources/css/app.css`.
- **Vite fonts**: Font loading (Instrument Sans) is handled via `laravel-vite-plugin`'s `fonts` option with `bunny()` in `vite.config.js`. Use `@fonts` directive in Blade templates.
- **Routing**: Web routes in `routes/web.php`, console commands in `routes/console.php`. App config centralized in `bootstrap/app.php` (no HTTP Kernel).
- **Code style**: Laravel Pint (PSR-12/Laravel). Run before committing.
- **Indentation**: 4 spaces, LF line endings (`.editorconfig`).

## Testing

- PHPUnit 12 with in-memory SQLite (`phpunit.xml` sets `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`).
- Feature tests extend `Tests\TestCase`. Unit tests extend `PHPUnit\Framework\TestCase`.
- `RefreshDatabase` trait is available but commented out in example tests.
- Pulse, Telescope, and Nightwatch are disabled in test env.

## Gotchas

- `.npmrc` sets `ignore-scripts=true`. `composer setup` passes `--ignore-scripts` to `npm install` to match.
- Vite watch ignores `storage/framework/views/**` (compiled Blade views).
- No CI/CD workflows or Docker config exist.
- `bootstrap/app.php` configures routing (web + console) and exception handling directly—no `app/Http/Kernel.php`.
