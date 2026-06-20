<?php

namespace App\Livewire\Transaction;

use Livewire\Component;

class Create extends Component
{
    public string $type = 'expense';

    public string $amount = '';

    public string $walletId = '';

    public ?string $categoryId = null;

    public string $description = '';

    public string $date = '';

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $wallet = auth()->user()->wallets()->first();
        $this->walletId = (string) $wallet?->id;
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'walletId' => 'required|exists:wallets,id',
            'type' => 'required|in:income,expense,transfer',
            'date' => 'required|date',
        ]);

        $wallet = auth()->user()->wallets()->findOrFail($this->walletId);

        if ($this->type === 'expense' && $wallet->balance < (float) $this->amount) {
            session()->flash('error', 'Saldo dompet tidak mencukupi.');

            return;
        }

        $transaction = auth()->user()->transactions()->create([
            'wallet_id' => $wallet->id,
            'category_id' => $this->categoryId ?: null,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
        ]);

        if ($this->type === 'income') {
            $wallet->increment('balance', (float) $this->amount);
        } elseif ($this->type === 'expense') {
            $wallet->decrement('balance', (float) $this->amount);
        }

        session()->flash('success', 'Transaksi berhasil dicatat.');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        $wallets = auth()->user()->wallets;
        $categories = auth()->user()->categories;

        return view('livewire.transaction.create', [
            'wallets' => $wallets,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
