<?php

namespace App\Livewire;

use App\Models\Account;
use Livewire\Component;

class AccountDetails extends Component
{   

    public Account $record;
    public function render()
    {

        return view('livewire.account-details');
    }
}
