<?php

namespace App\Livewire\Wallet;

use App\Models\Wallet;
use Livewire\Component;

class Detail extends Component
{
    public Wallet $wallet;

    public string $filter = 'all';

    public function mount(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function render()
    {
        $query = $this->wallet->transactions()->with('category');

        if ($this->filter === 'income') {
            $query->where('type', 'income');
        } elseif ($this->filter === 'expense') {
            $query->where('type', 'expense');
        }

        $transactions = $query->latest()->get();

        return view('livewire.wallet.detail', [
            'transactions' => $transactions,
        ])->layout('layouts.app');
    }
}
