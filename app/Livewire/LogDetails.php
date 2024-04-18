<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class LogDetails extends Component
{   

    public Transaction $recoord;
    public function render()    
    {
        return view('livewire.log-details');
    }
}
