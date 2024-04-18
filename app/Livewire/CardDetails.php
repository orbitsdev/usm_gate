<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;

class CardDetails extends Component
{   

    public Card $record;
    public function render()
    {
        return view('livewire.card-details');
    }
}
