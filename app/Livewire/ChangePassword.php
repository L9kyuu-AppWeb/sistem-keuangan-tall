<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function save(): void
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($this->current_password, $user->password)) {
            session()->flash('error', 'Password lama salah.');

            return;
        }

        $user->update(['password' => $this->password]);

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('success', 'Kata sandi berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.change-password')->layout('layouts.app');
    }
}
