<?php

namespace App\Livewire\Transaction;

use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public function render()
    {
        $query = auth()->user()->transactions()->with(['wallet', 'category']);

        if ($this->search) {
            $query->where('description', 'like', '%'.$this->search.'%');
        }

        $transactions = $query->latest()->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        return view('livewire.transaction.index', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ])->layout('layouts.app');
    }
}
