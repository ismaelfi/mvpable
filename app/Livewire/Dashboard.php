<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        return view('livewire.dashboard', [
            'subscribed' => $user->subscribed('default'),
            'plan' => $user->subscription('default')->stripe_plan ?? null,
        ]);
    }
}
