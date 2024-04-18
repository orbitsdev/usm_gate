<?php

namespace App\Livewire;

use App\Models\Record;
use Livewire\Component;

class RecordDetails extends Component

{

    public Record $record;
    public function render()
    {
        return view('livewire.record-details');
    }
}
