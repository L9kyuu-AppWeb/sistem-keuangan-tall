<?php

namespace App\Livewire\Auth;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        foreach (Category::defaultSystemCategories() as $cat) {
            Category::create(array_merge($cat, ['user_id' => $user->id]));
        }

        $user->wallets()->createMany([
            ['name' => 'Uang Tunai', 'type' => 'cash', 'icon' => 'cash', 'balance' => 0],
            ['name' => 'Rekening Bank', 'type' => 'bank', 'icon' => 'building-bank', 'balance' => 0],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
