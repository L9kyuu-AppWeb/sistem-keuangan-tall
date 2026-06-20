<?php

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password'),
        ]);

        // System categories
        foreach (Category::defaultSystemCategories() as $cat) {
            Category::create(array_merge($cat, ['user_id' => $user->id]));
        }

        $categories = $user->categories;

        // Wallets
        $cash = $user->wallets()->create([
            'name' => 'Uang Tunai',
            'type' => 'cash',
            'icon' => 'cash',
            'balance' => 1250000,
        ]);

        $bca = $user->wallets()->create([
            'name' => 'BCA Tabungan',
            'type' => 'bank',
            'icon' => 'building-bank',
            'balance' => 13500000,
        ]);

        // Transactions
        $user->transactions()->create([
            'wallet_id' => $bca->id,
            'category_id' => null,
            'type' => 'income',
            'amount' => 8500000,
            'description' => 'Gaji Budi',
            'date' => now(),
        ]);

        $belanjaCat = $categories->where('name', 'Belanja')->first();
        $user->transactions()->create([
            'wallet_id' => $cash->id,
            'category_id' => $belanjaCat?->id,
            'type' => 'expense',
            'amount' => 85000,
            'description' => 'Belanja Sayur',
            'date' => now()->subDay(),
        ]);

        $tagihanCat = $categories->where('name', 'Tagihan')->first();
        $user->transactions()->create([
            'wallet_id' => $bca->id,
            'category_id' => $tagihanCat?->id,
            'type' => 'expense',
            'amount' => 320000,
            'description' => 'Tagihan Listrik PLN',
            'date' => now()->subDays(2),
        ]);

        $makanCat = $categories->where('name', 'Makan')->first();
        $user->transactions()->create([
            'wallet_id' => $cash->id,
            'category_id' => $makanCat?->id,
            'type' => 'expense',
            'amount' => 185000,
            'description' => 'Makan Siang Sekeluarga',
            'date' => now()->subDays(3),
        ]);

        // Transfer
        $user->transactions()->create([
            'wallet_id' => $cash->id,
            'transfer_to_wallet_id' => $bca->id,
            'type' => 'transfer',
            'amount' => 500000,
            'description' => 'Setor ke BCA',
            'date' => now()->subDays(3),
        ]);

        $hiburanCat = $categories->where('name', 'Hiburan')->first();
        $user->transactions()->create([
            'wallet_id' => $bca->id,
            'category_id' => $hiburanCat?->id,
            'type' => 'expense',
            'amount' => 186000,
            'description' => 'Netflix',
            'date' => now()->subDays(5),
        ]);

        $transportCat = $categories->where('name', 'Transport')->first();
        $user->transactions()->create([
            'wallet_id' => $cash->id,
            'category_id' => $transportCat?->id,
            'type' => 'expense',
            'amount' => 150000,
            'description' => 'Bensin',
            'date' => now()->subDays(5),
        ]);

        // Gold holdings
        $user->goldHoldings()->create([
            'type' => 'buy',
            'grams' => 5,
            'price_per_gram' => 1000000,
            'total_cost' => 5000000,
            'date' => now()->subMonths(3)->startOfMonth(),
            'notes' => 'Beli emas Antam',
        ]);

        $user->goldHoldings()->create([
            'type' => 'buy',
            'grams' => 7.5,
            'price_per_gram' => 975000,
            'total_cost' => 7312500,
            'date' => now()->subMonths(5)->startOfMonth(),
            'notes' => 'Beli emas Antam',
        ]);

        // Budget
        $user->budgets()->create([
            'month' => now()->format('Y-m'),
            'amount' => 5000000,
        ]);

        // Notifications
        $user->notifications()->create([
            'type' => 'income',
            'title' => 'Pemasukan baru dicatat',
            'message' => 'Gaji Budi sebesar Rp 8.500.000 berhasil dicatat ke BCA Tabungan.',
        ]);

        $user->notifications()->create([
            'type' => 'expense',
            'title' => 'Anggaran hampir habis',
            'message' => 'Anggaran bulanan Anda sudah terpakai 65%. Tersisa Rp 1.750.000.',
        ]);

        $user->notifications()->create([
            'type' => 'info',
            'title' => 'Coba Pro 7 hari gratis',
            'message' => 'Hubungkan akun istri dan bagi buku kas bersama. Coba Pro tanpa biaya!',
        ]);

        // Update wallet balances based on transactions
        $cash->update(['balance' => 1250000]);
        $bca->update(['balance' => 13500000]);
    }
}
