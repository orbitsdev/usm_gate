<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\Card;
use Livewire\Component;
use App\Events\LogCreation;
use App\Models\Transaction;
use Livewire\Attributes\On;

class MonitorScreen extends Component
{



    public Transaction $ransaction;

    public function render()
    {

        return view('livewire.monitor-screen', ['transaction' => Transaction::whereDate('created_at', today())->latest()->first()]);
                //  return view('livewire.monitor-screen', ['transaction' => Transaction::where('created_at', '>', now()->subMinutes(3))->latest()->first()]);

                // return view('livewire.monitor-screen', [
                //     'transaction' => Transaction::where('created_at', '>', now()->subSeconds(20))->latest()->first()
                // ]);
                

    }
}
