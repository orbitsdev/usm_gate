<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class MonitorScreen2 extends Component
{   

    public Transaction $ransaction;

    public function render()
    {
        return view('livewire.monitor-screen2', [
            'transaction' => Transaction::where('door_name', 'Door 2')->where('created_at', '>', now()->subSeconds(10))->latest()->first()
        ]);
    }
}
