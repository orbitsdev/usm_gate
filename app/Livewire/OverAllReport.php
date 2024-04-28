<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\Record;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\AccountType;
use App\Exports\OverAllExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
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
    public $time_start;
    public $time_end;

    
    public $period;



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

            if (!empty($this->date_start) && !empty($this->date_end)) {
                $filename = 'DAILY-RECORD-' . $this->date_start . '-' . $this->date_end;
            } else if (empty($date_end) && !empty($this->date_start)) {
                $filename = 'DAILY-RECORD-' . $this->date_start;
            } else if (empty($date_start) && !empty($this->date_end)) {
                $filename = 'DAILY-RECORD-' . $this->date_end;
            } else {

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

                Section::make('Filters')
                
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

                        DatePicker::make('date_start')
                            ->native(false)
                            ->live()
                            ->columnSpan(2)
                           
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {

                                $this->date_start = Carbon::parse($state)->isoFormat('MMMM DD, YYYY');
                                // dd($this->date_start);

                                if (!empty($state)) {
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
                                        // ->when($get('period') != 'all', function ($query) use ($get, $state) {
                                        //     // Apply date range filter
                                        //     $startDate = !empty($get('date_start')) ? Carbon::parse($get('date_start'))->startOfDay() : null;
                                        //     $endDate = !empty($get('date_end')) ? Carbon::parse($get('date_end'))->endOfDay() : null;
                            
                                        //     if (!empty($startDate) || !empty($endDate)) {
                                        //         if ($startDate && $endDate) {
                                        //             $query->whereBetween('created_at', [$startDate, $endDate]);
                                        //         } elseif ($startDate) {
                                        //             $query->where('created_at', '>=', $startDate);
                                        //         } elseif ($endDate) {
                                        //             $query->where('created_at', '<=', $endDate);
                                        //         }
                            
                                        //         // Apply time filter
                                        //         $timeCondition = $get('period') == 'am' ? '<' : '>=';
                                        //         $query->whereTime('created_at', $timeCondition, '12:00:00');
                                        //     }
                                        // })
                                        ->get();

                                    $this->records = $data;
                                } else {
                                    $this->records  = [];
                                }
                            })
                            ->label('Date Start')
                            ,

                      
                            DatePicker::make('date_end')
                            ->native(false)
                            ->live()
                            ->columnSpan(2)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $this->date_end = Carbon::parse($state)->isoFormat('MMMM DD, YYYY');
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

                                    // ->when($get('period') != 'all', function ($query) use ($get, $state) {
                                    //     // Apply date range filter
                                    //     $startDate = !empty($get('date_start')) ? Carbon::parse($get('date_start'))->startOfDay() : null;
                                    //     $endDate = !empty($get('date_end')) ? Carbon::parse($get('date_end'))->endOfDay() : null;
                        
                                    //     if (!empty($startDate) || !empty($endDate)) {
                                    //         if ($startDate && $endDate) {
                                    //             $query->whereBetween('created_at', [$startDate, $endDate]);
                                    //         } elseif ($startDate) {
                                    //             $query->where('created_at', '>=', $startDate);
                                    //         } elseif ($endDate) {
                                    //             $query->where('created_at', '<=', $endDate);
                                    //         }
                        
                                    //         // Apply time filter
                                    //         $timeCondition = $get('period') == 'am' ? '<' : '>=';
                                    //         $query->whereTime('created_at', $timeCondition, '12:00:00');
                                    //     }
                                    // })
                                    ->get();

                                $this->records = $data;
                            })
                            ->label('Date End'),
                            

                        // Select::make('period')
                        //     ->options([
                        //         'all' => 'All',
                        //         'am' => 'AM',
                        //         'pm' => 'PM',
                        //     ])
                        //     ->label('Time period')
                        //     ->live()
                        //     ->columnSpan(2)
                        //     ->default('all')
                        //     ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        //         $this->accountType = $get('account_type');
                        //         $this->period = $state;

                        //         $data = Record::orderBy('created_at', 'desc')
                        //             ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                        //                 $query->whereHas('card.account', function ($query) {
                        //                     $query->where('account_type', $this->accountType);
                        //                 });
                        //             })
                        //             ->when(!empty($get('date_start')) || !empty($get('date_end')), function ($query) use ($get, $state) {
                        //                 // Apply date range filter
                        //                 $startDate = !empty($get('date_start')) ? Carbon::parse($get('date_start'))->startOfDay() : null;
                        //                 $endDate = !empty($get('date_end')) ? Carbon::parse($get('date_end'))->endOfDay() : null;

                        //                 if (!empty($startDate) || !empty($endDate)) {
                        //                     if ($startDate && $endDate) {
                        //                         $query->whereBetween('created_at', [$startDate, $endDate]);
                        //                     } elseif ($startDate) {
                        //                         $query->where('created_at', '>=', $startDate);
                        //                     } elseif ($endDate) {
                        //                         $query->where('created_at', '<=', $endDate);
                        //                     }

                        //                     // Apply time filter
                        //                     $timeCondition = $state == 'am' ? '<' : '>=';
                        //                     $query->whereTime('created_at', $timeCondition, '12:00:00');
                        //                 }
                        //             })
                        //             ->get();

                        //         $this->records = $data;
                        //     }),


                        TimePicker::make('time_start')
                        ->seconds(false)
                        ->live()
                        ->columnSpan(2)
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {

                            // dd($state);
                            $this->time_start = $state;


                            $data = Record::orderBy('created_at', 'desc')
                            ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                                $query->whereHas('card.account', function ($query) {
                                    $query->where('account_type', $this->accountType);
                                });
                            })
                                ->when(!empty($get('date_start'))  && !empty($get('date_end')), function ($query) use ($state, $get) {

                                    $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_end'))->endOfDay();

                                    if (!empty($get('time_end'))) {
                                        $startTime = Carbon::parse($state)->addSeconds(0);
                                        $endTime = Carbon::parse($get('time_end'))->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);
                                        $formattedTime = $time->format('H:i:s'); // Format as HH:mm:ss

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->when(!empty($get('date_start'))  && empty($get('date_end')), function ($query) use ($state, $get) {
                                    $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_start'))->endOfDay();

                                    if (!empty($get('time_end'))) {
                                        $startTime = Carbon::parse($state)->addSeconds(0);
                                        $endTime = Carbon::parse($get('time_end'))->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->when(empty($get('date_start'))  && !empty($get('date_end')), function ($query) use ($state, $get) {
                                    $startDate = Carbon::parse($get('date_end'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_end'))->endOfDay();

                                    if (!empty($get('time_end'))) {
                                        $startTime = Carbon::parse($state)->addSeconds(0);
                                        $endTime = Carbon::parse($get('time_end'))->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->get();



                            $this->records = $data;
                        }),



                    TimePicker::make('time_end')
                        ->seconds(false)
                        ->live()
                        ->columnSpan(2)
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {

                            $this->time_end = $state;
                            $this->accountType = $get('accountType');
                            $data = Record::orderBy('created_at', 'desc')
                                
                            ->when($this->accountType != 'All' && !empty($this->accountType), function ($query) {
                                $query->whereHas('card.account', function ($query) {
                                    $query->where('account_type', $this->accountType);
                                });
                            })
                                ->when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($state, $get) {

                                    $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_end'))->endOfDay();

                                    if (!empty($get('time_start'))) {
                                        $startTime = Carbon::parse($get('time_start'))->addSeconds(0);
                                        $endTime = Carbon::parse($state)->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);
                                        $formattedTime = $time->format('H:i:s'); // Format as HH:mm:ss

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->when(!empty($get('date_start')) && empty($get('date_end')), function ($query) use ($state, $get) {
                                    $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_start'))->endOfDay();

                                    if (!empty($get('time_start'))) {
                                        $startTime = Carbon::parse($get('time_start'))->addSeconds(0);
                                        $endTime = Carbon::parse($state)->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->when(empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($state, $get) {
                                    $startDate = Carbon::parse($get('date_end'))->startOfDay();
                                    $endDate = Carbon::parse($get('date_end'))->endOfDay();

                                    if (!empty($get('time_start'))) {
                                        $startTime = Carbon::parse($get('time_start'))->addSeconds(0);
                                        $endTime = Carbon::parse($state)->addSeconds(59);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $startTime)
                                            ->whereTime('created_at', '<=', $endTime);
                                    } else {
                                        $time = Carbon::parse($state)->addSeconds(0);

                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereTime('created_at', '>=', $time);
                                    }
                                })
                                ->get();

                            $this->records = $data;
                        }),


                        Select::make('accountType')
                            ->options(AccountType::all()->pluck('name','name'))
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
                                        ->when(!empty($get('time_start')) && !empty($get('time_end')), function ($query) use($get,$state){
                                            $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                            $endDate = Carbon::parse($get('date_end'))->endOfDay();
                                            $startTime = Carbon::parse($get('time_start'))->addSeconds(0);
                                            $endTime = Carbon::parse($get('time_end'))->addSeconds(59);
                                            $query->whereBetween('created_at', [$startDate, $endDate])
                                                    ->whereTime('created_at', '>=', $startTime)
                                                    ->whereTime('created_at', '<=', $endTime);
                                           
                                        })
                                        ->when(!empty($get('time_start')) && empty($get('time_end')), function ($query) use($get,$state){
                                            $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                            $endDate = Carbon::parse($get('date_end'))->endOfDay();
                                            
                                            $time = Carbon::parse($get('time_start'))->addSeconds(0);
                                            $query->whereBetween('created_at', [$startDate, $endDate])
                                                ->whereTime('created_at', '>=', $time);
                                        })
                                        ->when(empty($get('time_start')) && !empty($get('time_end')), function ($query) use($get,$state){
                                            $startDate = Carbon::parse($get('date_start'))->startOfDay();
                                            $endDate = Carbon::parse($get('date_end'))->endOfDay();
                                            
                                            $time = Carbon::parse($get('time_end'))->addSeconds(0);
                                            $query->whereBetween('created_at', [$startDate, $endDate])
                                                ->whereTime('created_at', '>=', $time);
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
