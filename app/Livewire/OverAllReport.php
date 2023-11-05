<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\Record;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Exports\OverAllExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class OverAllReport extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];

    public $records = [];
    public $daySelected;
    public $accountType;
    public $dayData;
    public $day;

    public $date_start;
    public $date_end;



    public function mount()
    {
        $this->form->fill();
        $this->accountType = 'All';

        // $day = Day::orderBy('created_at', 'desc')->first();

        // if(!empty($day)){

        //     $this->dayData = Day::where('id', $day)->first();
        //     $this->records = Record::latest()->where('day_id', $day->id) ->get();
        //     $this->daySelected = $day->id;
        //  }  

        //  $this->dayData = Day::latest()->first();
        //  $this->records = Record::latest()->get();
    }
    public function exportToExcel()
    {

        if (count($this->records) > 0) {

            if(!empty($this->date_start) && !empty($this->date_end)){
                $filename = 'DAILY-RECORD-' . $this->date_start.'-'.$this->date_end;
            }else if(empty($date_end) && !empty($this->date_start)){
                $filename = 'DAILY-RECORD-' . $this->date_start;
            }else if(empty($date_start) && !empty($this->date_end)){
                $filename = 'DAILY-RECORD-' . $this->date_end;
                
            }else{
                
                    $filename = 'DAILY-RECORD-' . now()->format('Y-m-d');
            }

            // dd($filename);
            return Excel::download(new OverAllExport($this->records), $filename . '.xlsx');
        }
    }

    public function print()
    {
        $this->dispatch('printTable');
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
                        // Select::make('daySelected')
                        //     ->options(Day::latest()->whereHas('records')->orderBy('created_at', 'desc')->pluck('created_at', 'id')->map(function ($date) {
                        //         return $date->format('F d,  Y - l ');
                        //     }))


                        //     ->searchable()
                        //     ->columnSpan(2)
                        //     ->label('Date')
                        //     ->live()

                        //     ->afterStateUpdated(function (Get $get, Set $set, $state) {

                        //         $this->dayData = Day::where('id', $state)->first();

                        //         $data = Record::orderBy('created_at', 'desc')->when(!empty($state), function ($query) use ($state) {
                        //             $query->where('day_id', $state);
                        //         })
                        //             ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) use ($get) {
                        //                 $query->whereHas('card.account', function ($query) use ($get) {
                        //                     $query->where('account_type', $get('accountType'));
                        //                 });
                        //             })
                        //             ->get();
                        //         $this->records = $data;
                        //         // $this->dayData = Day::where('id', $state)->first();
                        //         // $data = Record::orderBy('created_at', 'desc')->where('day_id', $state)
                        //         // ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) use ($get) {
                        //         //     $query->whereHas('card.account', function($query) use($get){
                        //         //         $query->where('account_type', $get('accountType'));
                        //         //     });
                        //         // })
                        //         // ->get();
                        //         // $this->records = $data;

                        //     }),

                        Flatpickr::make('date_start')
                        ->live()
                        ->columnSpan(2)
                        ->dateFormat('F d, Y')
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {

                            $this->date_start = $state;

                            if(!empty($state)){
                                $this->accountType = $get('accountType');
                    
                                $data = Record::orderBy('created_at', 'desc')
                                    ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                                        $query->whereHas('card.account', function ($query) {
                                            $query->where('account_type', $this->accountType);
                                        });
                                    })
                                    ->when($state && !empty($get('date_end')), function ($query) use ($state, $get) {
                                        // Apply date range filter
                                        $query->whereBetween('created_at', [
                                            Carbon::parse($state)->startOfDay(),
                                            Carbon::parse($get('date_end'))->endOfDay(),
                                        ]);
                                    })
                                    ->when(empty($get('date_end')) && !empty($get('date_start')), function ($query) use ($get) {
                                        // Apply date_start filter only if date_start is selected and date_end is not selected
                                        $query->whereDate('created_at', Carbon::parse($get('date_start'))->format('Y-m-d'));
                                    })
                                    ->get();
                        
                                $this->records = $data;
                            }else{
                                $this->records  = [];
                            }
                           
                        }),
                    
                    Flatpickr::make('date_end')
                        ->dateFormat('F d, Y')
                        ->live()
                        ->columnSpan(2)
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $this->date_end = $state;
                            $this->accountType = $get('accountType');
                    
                            $data = Record::orderBy('created_at', 'desc')
                                ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                                    $query->whereHas('card.account', function ($query) {
                                        $query->where('account_type', $this->accountType);
                                    });
                                })
                                ->when($state && !empty($get('date_start')), function ($query) use ($state, $get) {
                                    // Apply date range filter
                                    $query->whereBetween('created_at', [
                                        Carbon::parse($get('date_start'))->startOfDay(),
                                        Carbon::parse($state)->endOfDay(),
                                    ]);
                                })
                                ->when(empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                                    // Apply date_end filter only if date_end is selected and date_start is not selected
                                    $query->whereDate('created_at', Carbon::parse($get('date_end'))->format('Y-m-d'));
                                })
                                ->get();
                    
                            $this->records = $data;
                        }),
                    
                    Select::make('accountType')
                        ->options([
                            'All' => 'All',
                            'Student' => 'Student',
                            'Staff' => 'Staff',
                            'Teacher' => 'Teacher',
                        ])
                        ->default('All')
                        ->searchable()
                        ->columnSpan(2)
                        ->label('Account')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $this->accountType = $state;
                    
                            // Check if both date_start and date_end are selected
                            if (!empty($get('date_start')) && !empty($get('date_end'))) {
                                $data = Record::orderBy('created_at', 'desc')
                                    ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                                        $query->whereHas('card.account', function ($query) {
                                            $query->where('account_type', $this->accountType);
                                        });
                                    })
                                    ->when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                                        // Apply date range filter
                                        $query->whereBetween('created_at', [
                                            Carbon::parse($get('date_start'))->startOfDay(),
                                            Carbon::parse($get('date_end'))->endOfDay(),
                                        ]);
                                    })
                                    ->get();
                    
                                $this->records = $data;
                            }
                        }),
                    


                    ]),




            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }
    public function render()
    {
        return view('livewire.over-all-report');
    }
}
