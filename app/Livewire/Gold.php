<?php

namespace App\Livewire;

use Livewire\Component;

class Gold extends Component
{
    public string $grams = '';

    public string $pricePerGram = '';

    public string $type = 'buy';

    public string $date = '';

    public string $notes = '';

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'grams' => 'required|numeric|min:0.001',
            'pricePerGram' => 'required|numeric|min:1',
            'type' => 'required|in:buy,sell',
            'date' => 'required|date',
        ]);

        if ($this->type === 'sell') {
            $totalGrams = auth()->user()->goldHoldings()
                ->where('type', 'buy')
                ->sum('grams') - auth()->user()->goldHoldings()
                ->where('type', 'sell')
                ->sum('grams');

            if ((float) $this->grams > $totalGrams) {
                session()->flash('error', 'Gramasi jual melebihi total kepemilikan.');

                return;
            }
        }

        auth()->user()->goldHoldings()->create([
            'type' => $this->type,
            'grams' => $this->grams,
            'price_per_gram' => $this->pricePerGram,
            'total_cost' => (float) $this->grams * (float) $this->pricePerGram,
            'date' => $this->date,
            'notes' => $this->notes,
        ]);

        session()->flash('success', 'Transaksi emas berhasil dicatat.');
        $this->reset(['grams', 'pricePerGram', 'notes']);
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $holdings = auth()->user()->goldHoldings()->latest()->get();

        $totalGrams = $holdings->where('type', 'buy')->sum('grams') -
            $holdings->where('type', 'sell')->sum('grams');

        $totalCost = $holdings->where('type', 'buy')->sum('total_cost') -
            $holdings->where('type', 'sell')->sum('total_cost');

        $avgPrice = $totalGrams > 0 ? $totalCost / $totalGrams : 0;

        return view('livewire.gold', [
            'holdings' => $holdings,
            'totalGrams' => $totalGrams,
            'totalCost' => $totalCost,
            'avgPrice' => $avgPrice,
        ])->layout('layouts.app');
    }
}
