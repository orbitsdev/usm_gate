<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Card;
use App\Models\Account;
use Livewire\Component;

class Dashboard extends Component
{   

    // public $total_accounts;
    // public $total_cards;
    // public $total_active_cards;
    // public $total_inactive_cards;
    // public $total_expired_cards;
    // public $total_blocked_cards;
    // public $total_days_that_has_records;

    public function mount(){
        
        // $this->total_accounts = Account::count();
        // $this->total_cards = Card::count();
        // $this->total_active_cards = Card::where('status', 'Active')->count();
        // $this->total_inactive_cards = Card::where('status', 'Inactive')->count();
        // $this->total_expired_cards = Card::where('status', 'Expired')->count();
        // $this->total_blocked_cards = Card::where('status', 'Blocked')->count();
        // $this->total_days_that_has_records = Day::whereHas('records')->count();
    }

    public function render()
    {

            
        return view('livewire.dashboard',[
            'total_accounts' => Account::count(),
            'total_teachers' => Account::where('account_type', 'Teacher')->count(),
            'total_students' => Account::where('account_type', 'Student')->count(),
            'total_staffs' => Account::where('account_type', 'Staff')->count(),
            'total_cards' =>Card::count(),
            'total_active_cards' => Card::where('status', 'Active')->count(),
            'total_inactive_cards' =>  Card::where('status', 'Inactive')->count(),
            'total_expired_cards' => Card::where('status', 'Expired')->count(),
            'total_blocked_cards' => Card::where('status', 'Blocked')->count(),
            'total_days_that_has_records' =>Day::whereHas('records')->count(),
        ]);
    }
}
