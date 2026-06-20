<?php

namespace App\Livewire\Wallet;

use App\Models\Wallet;
use Livewire\Component;

class Index extends Component
{
    public string $name = '';

    public string $type = 'cash';

    public ?string $transferFrom = null;

    public ?string $transferTo = null;

    public string $transferAmount = '';

    public bool $showCreate = false;

    public function create()
    {
        $user = auth()->user();
        $walletCount = $user->wallets()->count();
        $limit = $user->walletLimit();

        if ($walletCount >= $limit) {
            session()->flash('error', 'Batas dompet gratis (2) tercapai. Upgrade ke Pro untuk dompet tak terbatas.');

            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,bank,ewallet',
        ]);

        $user->wallets()->create([
            'name' => $this->name,
            'type' => $this->type,
            'icon' => Wallet::iconForType($this->type),
            'balance' => 0,
        ]);

        $this->reset(['name', 'type', 'showCreate']);
        session()->flash('success', 'Dompet berhasil ditambahkan.');
    }

    public function transfer()
    {
        $this->validate([
            'transferFrom' => 'required|exists:wallets,id',
            'transferTo' => 'required|exists:wallets,id|different:transferFrom',
            'transferAmount' => 'required|numeric|min:1',
        ]);

        $fromWallet = Wallet::findOrFail($this->transferFrom);
        $toWallet = Wallet::findOrFail($this->transferTo);

        if ($fromWallet->balance < (float) $this->transferAmount) {
            session()->flash('transfer_error', 'Saldo tidak mencukupi.');

            return;
        }

        $fromWallet->decrement('balance', (float) $this->transferAmount);
        $toWallet->increment('balance', (float) $this->transferAmount);

        auth()->user()->transactions()->create([
            'wallet_id' => $fromWallet->id,
            'transfer_to_wallet_id' => $toWallet->id,
            'type' => 'transfer',
            'amount' => $this->transferAmount,
            'description' => 'Pindah saldo: '.$fromWallet->name.' → '.$toWallet->name,
            'date' => now(),
        ]);

        $this->reset(['transferFrom', 'transferTo', 'transferAmount']);
        session()->flash('transfer_success', 'Saldo berhasil dipindahkan.');
    }

    public function render()
    {
        $wallets = auth()->user()->wallets()->orderBy('created_at')->get();
        $totalBalance = $wallets->sum('balance');
        $walletCount = $wallets->count();
        $limit = auth()->user()->walletLimit();
        $atLimit = $walletCount >= $limit;

        return view('livewire.wallet.index', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance,
            'walletCount' => $walletCount,
            'limit' => $limit,
            'atLimit' => $atLimit,
        ])->layout('layouts.app');
    }
}
