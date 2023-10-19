<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\Card;
use Livewire\Component;
use App\Events\LogCreation;
use Livewire\Attributes\On; 

class MonitorScreen extends Component
{   

   public $text;

   public Log $log;
   public Card $card;
    

   
    
    
        
        
        
         #[On('echo:card,Scanned')]
        //  #[On('echo:log,LogCreation')]
        
        public function notifyNewLog($event)
        {   
            // $this->log = Log::find($event['id']);
            $this->card = Card::find($event['id']);
        }




    public function render()
    {
        return view('livewire.monitor-screen');
    }
}
