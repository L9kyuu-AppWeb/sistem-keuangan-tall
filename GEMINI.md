# Project: Filament Project (TALL Stack)

This is a modern TALL stack application built with Tailwind CSS, AlpineJS, Laravel, and Livewire.

## Project Overview

- **Stack:** TALL (Tailwind CSS 4, AlpineJS, Laravel 13+, Livewire 4)
- **Language:** PHP 8.3+
- **Frontend Tooling:** Vite, Tailwind CSS 4
- **Architecture:** Standard Laravel structure with Livewire for reactive components.
- **Key Features:**
    - Reactive UI components via Livewire.
    - AlpineJS integration (bundled with Livewire).
    - Uses modern PHP attributes for Eloquent model configuration (e.g., `#[Fillable]`, `#[Hidden]`).
    - Integrated development environment via `composer dev`.

## Building and Running

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js and npm

### Initial Setup
Run the following command to install dependencies, set up environment variables, generate application keys, and build assets:
```bash
composer setup
```

### Development
To start the development server, queue worker, log tailing, and Vite development server simultaneously:
```bash
composer dev
```

### Testing
To run the test suite:
```bash
composer test
```
Alternatively, use Artisan:
```bash
php artisan test
```

### Linting and Formatting
The project uses **Laravel Pint** for code style. To format the code:
```bash
vendor/bin/pint
```

## Development Conventions

- **Code Style:** Adhere to Laravel's coding standards using PSR-12/Laravel via Pint.
- **Modern PHP:** Use modern PHP features where appropriate, such as attributes for Eloquent models and constructor property promotion.
- **Routing:** 
    - Web routes are defined in `routes/web.php`.
    - Console commands are defined in `routes/console.php`.
    - Application configuration (middleware, routing, exceptions) is centralized in `bootstrap/app.php`.
- **Models:** Models are located in `app/Models/`. Note the use of attributes for `Fillable` and `Hidden` properties.
- **Assets:** Frontend assets are managed by Vite. CSS is handled via Tailwind CSS 4, integrated directly into Vite.

## Key Files and Directories

- `app/`: Contains core application code (Models, Controllers, Providers).
- `bootstrap/app.php`: The entry point for application configuration.
- `config/`: Application configuration files.
- `database/`: Database migrations, factories, and seeders.
- `public/`: The web root.
- `resources/`: Contains views (Blade), CSS, and JS.
- `routes/`: Application route definitions.
- `tests/`: Automated tests.
- `vite.config.js`: Vite configuration.
- `composer.json`: PHP dependencies and script definitions.
- `package.json`: Frontend dependencies and script definitions.
