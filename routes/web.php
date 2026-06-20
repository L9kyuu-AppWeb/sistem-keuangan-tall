<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Budget;
use App\Livewire\Dashboard;
use App\Livewire\Family;
use App\Livewire\Gold;
use App\Livewire\Notification;
use App\Livewire\Paywall;
use App\Livewire\Profile;
use App\Livewire\Transaction\Create as TransactionCreate;
use App\Livewire\Transaction\Index as TransactionIndex;
use App\Livewire\Wallet\Detail as WalletDetail;
use App\Livewire\Wallet\Index as WalletIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('splash');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/app/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/app/budget', Budget::class)->name('budget');
    Route::get('/app/wallets', WalletIndex::class)->name('wallets');
    Route::get('/app/wallet/{wallet}', WalletDetail::class)->name('wallet.detail');
    Route::get('/app/transactions/create', TransactionCreate::class)->name('transaction.create');
    Route::get('/app/transactions', TransactionIndex::class)->name('transactions');
    Route::get('/app/gold', Gold::class)->name('gold');
    Route::get('/app/family', Family::class)->name('family');
    Route::get('/app/profile', Profile::class)->name('profile');
    Route::get('/app/notifications', Notification::class)->name('notifications');
    Route::get('/app/paywall', Paywall::class)->name('paywall');
});
