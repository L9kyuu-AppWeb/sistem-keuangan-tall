<?php

namespace App\Livewire;

use Livewire\Component;

class Family extends Component
{
    public function render()
    {
        return view('livewire.family')->layout('layouts.app');
    }
}
