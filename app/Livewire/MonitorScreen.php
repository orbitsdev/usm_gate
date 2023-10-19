<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\LogCreation;
use Livewire\Attributes\On; 

class MonitorScreen extends Component
{   

    

    
    public $log;

    

   
    #[On('echo:log,LogCreation')]

    public function notifyNewOrder($event)
    {
        $this->log = 'Working';
    }

    public function render()
    {
        return view('livewire.monitor-screen');
    }
}
