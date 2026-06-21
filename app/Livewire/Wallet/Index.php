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

    // Edit
    public ?int $editingId = null;

    public string $editName = '';

    public string $editType = 'cash';

    // Delete confirm
    public ?int $deletingId = null;

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
            'is_active' => true,
        ]);

        $this->reset(['name', 'type', 'showCreate']);
        session()->flash('success', 'Dompet berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $wallet = Wallet::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId = $id;
        $this->editName = $wallet->name;
        $this->editType = $wallet->type;
        $this->showCreate = false;
        $this->deletingId = null;
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'editName', 'editType']);
    }

    public function update()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editType' => 'required|in:cash,bank,ewallet',
        ]);

        $wallet = Wallet::where('user_id', auth()->id())->findOrFail($this->editingId);
        $wallet->update([
            'name' => $this->editName,
            'type' => $this->editType,
            'icon' => Wallet::iconForType($this->editType),
        ]);

        $this->reset(['editingId', 'editName', 'editType']);
        session()->flash('success', 'Dompet berhasil diperbarui.');
    }

    public function confirmDelete(int $id)
    {
        $wallet = Wallet::where('user_id', auth()->id())->findOrFail($id);
        $this->deletingId = $id;
        $this->editingId = null;
    }

    public function cancelDelete()
    {
        $this->deletingId = null;
    }

    public function delete(int $id)
    {
        $wallet = Wallet::where('user_id', auth()->id())->findOrFail($id);

        if ($wallet->transactions()->count() > 0) {
            $wallet->update(['is_active' => false]);
            $this->deletingId = null;
            session()->flash('success', 'Dompet dinonaktifkan (masih ada transaksi).');

            return;
        }

        $wallet->delete();
        $this->deletingId = null;
        session()->flash('success', 'Dompet berhasil dihapus.');
    }

    public function toggleActive(int $id)
    {
        $wallet = Wallet::where('user_id', auth()->id())->findOrFail($id);
        $wallet->update(['is_active' => ! $wallet->is_active]);
        session()->flash('success', $wallet->is_active ? 'Dompet diaktifkan.' : 'Dompet dinonaktifkan.');
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
        $totalBalance = $wallets->where('is_active', true)->sum('balance');
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
