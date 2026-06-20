<?php

namespace App\Livewire;

use Livewire\Component;

class Notification extends Component
{
    public function render()
    {
        $notifications = auth()->user()->notifications()->latest()->get();

        return view('livewire.notification', [
            'notifications' => $notifications,
        ])->layout('layouts.app');
    }
}
