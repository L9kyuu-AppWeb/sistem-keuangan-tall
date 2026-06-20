<?php

namespace App\Livewire;

use Livewire\Component;

class Paywall extends Component
{
    public function render()
    {
        return view('livewire.paywall')->layout('layouts.app');
    }
}
