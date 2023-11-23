<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Card;
use App\Models\Account;
use Livewire\Component;
use Filament\Actions\Action;
use App\Exports\AccountExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class Dashboard extends Component implements HasForms, HasActions
{   
    use InteractsWithActions;
    use InteractsWithForms;
 
    // public $total_accounts;
    // public $total_cards;
    // public $total_active_cards;
    // public $total_inactive_cards;
    // public $total_expired_cards;
    // public $total_blocked_cards;
    // public $total_days_that_has_records;
    public ?array $data = [];
    // public function back(): Action
    // {
    //     return Action::make('Download')
    //     ->color('gray')
    //     ->icon('heroicon-m-arrow-down-tray')
    //     ->url(fn (): string => route('download-total-account'));
    // }
    public function downloadTotalAccounts(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-account'));
    }
    public function downloadTotalNoCardAccounts(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-account-no-card'));
    }
    public function downloadTotalTeachers(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-teachers'));
    }
    public function downloadTotalStudents(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-students'));
    }
    public function downloadTotalGuests(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-guests'));
    }
    public function downloadTotalStaffs(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-staffs'));
    }
    public function downloadTotalCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-cards'));
    }
    public function downloadTotalActiveCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-active-cards'));
    }
    public function downloadTotalInactiveCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-inactive-cards'));
    }
    public function downloadTotalExpiredCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-expired-cards'));
    }
    public function downloadTotalBlockedCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-blocked-cards'));
    }
    public function totalNoAccountCards(): Action
    {
        return Action::make('Download')
        ->color('gray')
        ->icon('heroicon-m-arrow-down-tray')
        ->url(fn (): string => route('download.total-no-account-cards'));
    }
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
            'total_accounts_no_card' => Account::whereDoesntHave('card')->count(),
            'total_teachers' => Account::where('account_type', 'Teacher')->count(),
            'total_students' => Account::where('account_type', 'Student')->count(),
            'total_staffs' => Account::where('account_type', 'Staff')->count(),
            'total_guest' => Account::where('account_type', 'Guest')->count(),
            'total_cards' =>Card::count(),
            'total_active_cards' => Card::where('status', 'Active')->count(),
            'total_inactive_cards' =>  Card::where('status', 'Inactive')->count(),
            'total_expired_cards' => Card::where('status', 'Expired')->count(),
            'total_blocked_cards' => Card::where('status', 'Blocked')->count(),
            'total_no_account_cards' => Card::whereDoesntHave('account')->count(),
            'total_days_that_has_records' =>Day::whereHas('records')->count(),
            'total_days_that_has_records_no_exit' =>Day::whereHas('records', function($query){
                $query->where('exit', false);
            })->count(),
        ]);
    }
}
