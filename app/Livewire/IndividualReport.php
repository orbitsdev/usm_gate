<?php

namespace App\Livewire;

use App\Models\Day;
use App\Models\Record;
use App\Models\Account;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use App\Exports\IndividualReportExport;
use Filament\Forms\Concerns\InteractsWithForms;

class IndividualReport extends Component  implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $daySelected;
    public $dayData;
    public $records = [];
    public $name;
    
    public $account;

    public function mount(){
        $this->form->fill();
        $this->dayData = Day::latest()->first();
    }

    public function exportToExcel(){
        
        if(count($this->records) > 0){

            if(!empty($this->account)){
                $filename = $this->account?->first_name.'-'.$this->account?->last_name.'-'.$this->dayData->created_at->format('F-d-Y').'-Report';  
                
            }else{
                
                $filename = 'individualreport';
            }
            
            return Excel::download(new IndividualReportExport($this->records), $filename.'.xlsx');
        }

       
    }

    public function print()
    {   
        $this->dispatch('printIndividualTable');
    }
    

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 9,
                ])
                ->schema([
                    Select::make('daySelected')
                ->options(Day::orderBy('created_at', 'desc')->pluck('created_at', 'id')->map(function ($date) {
                    return $date->format('F d,  Y - l ');
                }))
                ->columnSpan(2)
              
                ->searchable()
                ->label('Date')
                ->reactive()
                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                   
                    
                    $this->dayData = Day::where('id', $state)->first();

                    $this->records = Record::when(!empty($get('name')), function ($query) use ($get) {
                        $query->whereHas('card.account', function ($query) use ($get) {
                            $query->where('id', $get('name'));
                        });
                    })->where('day_id', $state)->get();

                    if (!empty($state)) {
                        $set('name', null);
                    }
                  
               
                    
                }),
              
                Select::make('name')
                ->options(function (Get $get, Set $set, $state) {
                    
                    return Account::when(!empty($get('daySelected')) , function($query) use($get){
                        $query->whereHas('card.records', function($query)use($get){
                            $query->where('day_id', $get('daySelected'));
                        });
                    } )
                    
                    ->whereHas('card.records')->select(DB::raw("CONCAT(last_name, ' ', first_name, ' ', middle_name, ' - ', account_type) AS full_name"), 'id')->pluck('full_name', 'id')->toArray();
                })
                
                ->columnSpan(2)
                ->searchable()
                ->label('Full name')
                ->live()
                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                  
                    $this->account = Account::where('id', $state)->first();
                    // dd($this->student);

                    // dd($state);
                    if(!empty($get('daySelected'))){
                      
                        $this->records = Record::orderBy('created_at', 'desc')
                        
                        ->where('day_id', $get('daySelected'))
                        ->when(!empty($state), function($query) use($state){
                           $query->whereHas('card', function($query) use($state){
                                $query->where('account_id', $state);
                           });
                        })
                        ->get();

                        
                        // ->when($get('selectedStatus') != 'all', function ($query) use ($get) {
                        //     $query->whereHas('logout', function ($query) use ($get) {
                        //         $query->where('status', $get('selectedStatus'));
                        //     });
                        // })

                       
                    }

                    
                })->searchable(),

                // Select::make('name')
                // ->options(function (Get $get, Set $set, $state) {
                //     return Account::whereHas('card.records')->select(DB::raw("CONCAT(first_name, ' ', last_name) AS full_name"), 'id')->pluck('full_name', 'id')->toArray();
                // })
                
                // ->columnSpan(2)
                // ->searchable()
                // ->label('Full name')
                // ->live()
                // ->afterStateUpdated(function (Get $get, Set $set, $state) {
                //         dd($state);
                   
                    
                // })->searchable(),

                ]),
               
             
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.individual-report');
    }
}
