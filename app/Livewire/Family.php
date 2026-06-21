<?php

namespace App\Livewire;

use App\Models\FamilyGroup;
use App\Models\Transaction;
use Livewire\Component;

class Family extends Component
{
    public string $joinCode = '';

    public string $newGroupName = '';

    public function createGroup(): void
    {
        if (! auth()->user()->isPro()) {
            session()->flash('error', 'Family Sync hanya untuk akun Pro.');

            return;
        }
        if (auth()->user()->family_group_id) {
            session()->flash('error', 'Anda sudah tergabung di sebuah grup.');

            return;
        }

        $code = FamilyGroup::generateCode();
        $group = FamilyGroup::create([
            'name' => 'Keluarga '.auth()->user()->name,
            'code' => $code,
        ]);

        auth()->user()->update([
            'family_group_id' => $group->id,
            'family_role' => 'owner',
        ]);

        session()->flash('success', 'Grup keluarga dibuat! Kode: '.$code);
    }

    public function joinGroup(): void
    {
        if (! auth()->user()->isPro()) {
            session()->flash('error', 'Family Sync hanya untuk akun Pro.');

            return;
        }
        if (auth()->user()->family_group_id) {
            session()->flash('error', 'Anda sudah tergabung di sebuah grup. Keluar dulu.');

            return;
        }

        $code = strtoupper(trim($this->joinCode));
        $group = FamilyGroup::where('code', $code)->first();

        if (! $group) {
            session()->flash('error', 'Kode tidak ditemukan. Periksa kode yang diberikan.');

            return;
        }

        auth()->user()->update([
            'family_group_id' => $group->id,
            'family_role' => 'member',
        ]);

        $this->joinCode = '';
        session()->flash('success', 'Berhasil bergabung dengan grup '.$group->name.'!');
    }

    public function leaveGroup(): void
    {
        $user = auth()->user();
        if (! $user->family_group_id) {
            return;
        }

        // If owner, delete whole group
        if ($user->family_role === 'owner') {
            $group = FamilyGroup::find($user->family_group_id);
            if ($group) {
                // Remove all members
                $group->members()->update([
                    'family_group_id' => null,
                    'family_role' => null,
                ]);
                $group->delete();
            }
        }

        $user->update([
            'family_group_id' => null,
            'family_role' => null,
        ]);

        session()->flash('success', 'Anda keluar dari grup keluarga.');
    }

    public function render()
    {
        $user = auth()->user();
        $group = $user->familyGroup;
        $members = $group ? $group->members()->get() : collect();
        $txns = collect();

        if ($group) {
            $memberIds = $members->pluck('id')->toArray();
            $txns = Transaction::with(['wallet', 'category', 'user'])
                ->whereIn('user_id', $memberIds)
                ->latest()
                ->take(10)
                ->get();
        }

        return view('livewire.family', [
            'group' => $group,
            'members' => $members,
            'transactions' => $txns,
        ])->layout('layouts.app');
    }
}
