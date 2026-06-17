# TALL Stack Template (Laravel 13+)

A modern, opinionated, and ready-to-use template for building reactive web applications using the **TALL Stack**. This template is designed to provide a blazing-fast starting point with the latest technologies.

## 🚀 Features

- **Laravel 13+**: The latest version of the PHP framework for web artisans.
- **Livewire 4**: Full-stack framework for Laravel that takes the pain out of building dynamic interfaces.
- **Tailwind CSS 4**: The latest evolution of the utility-first CSS framework, featuring a high-performance engine and zero-config setup.
- **AlpineJS**: A rugged, minimal framework for composing JavaScript behavior in your markup (integrated via Livewire).
- **Vite**: Ultra-fast frontend build tool.
- **Laravel Pint**: Pre-configured code style for consistent PHP formatting.
- **Modern PHP Attributes**: Models are configured using PHP 8.3+ attributes for cleaner code.

## 🛠️ Getting Started

### Prerequisites

Ensure you have the following installed:
- PHP 8.3 or higher
- Composer
- Node.js & NPM
- SQLite (or your preferred database)

### Installation

1. **Clone the template:**
   ```bash
   git clone git@github.com:L9kyuu-AppWeb/template-TALL-Stack.git your-project-name
   cd your-project-name
   ```

2. **Run the setup command:**
   This command installs PHP/NPM dependencies, generates the app key, and prepares the database.
   ```bash
   composer setup
   ```

3. **Start the development server:**
   This template includes a pre-configured `dev` script that runs the server, Vite, and the queue worker simultaneously.
   ```bash
   composer dev
   ```

## 📖 Usage

### Building Components
To create a new Livewire component:
```bash
php artisan make:livewire ComponentName
```

### Styling
Tailwind CSS 4 is configured in `resources/css/app.css`. You can add your theme customizations directly in the `@theme` block.

### Code Quality
Keep your code clean by running:
```bash
vendor/bin/pint
```

## 📜 License

This template is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
