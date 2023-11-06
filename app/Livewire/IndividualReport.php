<?php

namespace App\Livewire;

use Carbon\Carbon;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class IndividualReport extends Component  implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $daySelected;
    public $dayData;
    public $records = [];
    public $name;

    public $account;



    public $date_start;
    public $date_end;
    public $time_start;
    public $time_end;
    public $period;
    public $debug;


    public function mount()
    {
        $this->form->fill();
        $this->dayData = Day::latest()->first();
    }

    public function exportToExcel()
    {
        if (count($this->records) > 0) {
            $filename = '';

            if (!empty($this->account)) {
                $filename = $this->account->first_name . '-' . $this->account->last_name;

                if (!empty($this->date_start) && !empty($this->date_end)) {
                    $rangeday = 'DAILY-RECORD-' . $this->date_start . '-' . $this->date_end;
                } else if (empty($this->date_end) && !empty($this->date_start)) {
                    $rangeday = 'DAILY-RECORD-' . $this->date_start;
                } else if (empty($this->date_start) && !empty($this->date_end)) {
                    $rangeday = 'DAILY-RECORD-' . $this->date_end;
                }

                $filename .= '-' . $rangeday;
            } else {
                $filename = 'individualreport';
            }

            return Excel::download(new IndividualReportExport($this->records), $filename . '.xlsx');
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
                        //     Select::make('daySelected')
                        // ->options(Day::orderBy('created_at', 'desc')->pluck('created_at', 'id')->map(function ($date) {
                        //     return $date->format('F d,  Y - l ');
                        // }))
                        // ->columnSpan(2)

                        // ->searchable()
                        // ->label('Date')
                        // ->reactive()
                        // ->afterStateUpdated(function (Get $get, Set $set, $state) {


                        //     $this->dayData = Day::where('id', $state)->first();

                        //     $this->records = Record::when(!empty($get('name')), function ($query) use ($get) {
                        //         $query->whereHas('card.account', function ($query) use ($get) {
                        //             $query->where('id', $get('name'));
                        //         });
                        //     })->where('day_id', $state)->get();

                        //     if (!empty($state)) {
                        //         $set('name', null);
                        //     }



                        // }),

                        // Select::make('name')
                        // ->options(function (Get $get, Set $set, $state) {

                        //     return Account::when(!empty($get('daySelected')) , function($query) use($get){
                        //         $query->whereHas('card.records', function($query)use($get){
                        //             $query->where('day_id', $get('daySelected'));
                        //         });
                        //     } )

                        //     ->whereHas('card.records')->select(DB::raw("CONCAT(last_name, ' ', first_name, ' ', middle_name, ' - ', account_type) AS full_name"), 'id')->pluck('full_name', 'id')->toArray();
                        // })

                        // ->columnSpan(2)
                        // ->searchable()
                        // ->label('Full name')
                        // ->live()
                        // ->afterStateUpdated(function (Get $get, Set $set, $state) {

                        //     $this->account = Account::where('id', $state)->first();
                        //     // dd($this->student);

                        //     // dd($state);
                        //     if(!empty($get('daySelected'))){

                        //         $this->records = Record::orderBy('created_at', 'desc')

                        //         ->where('day_id', $get('daySelected'))
                        //         ->when(!empty($state), function($query) use($state){
                        //            $query->whereHas('card', function($query) use($state){
                        //                 $query->where('account_id', $state);
                        //            });
                        //         })
                        //         ->get();


                        //         // ->when($get('selectedStatus') != 'all', function ($query) use ($get) {
                        //         //     $query->whereHas('logout', function ($query) use ($get) {
                        //         //         $query->where('status', $get('selectedStatus'));
                        //         //     });
                        //         // })


                        //     }


                        // })->searchable(),

                        //     Select::make('name')
                        //     ->options(function (Get $get, Set $set, $state) {

                        //         return Account::when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                        //             $query->whereHas('card.records', function ($query) use ($get) {
                        //                 $query->whereBetween('created_at', [
                        //                     Carbon::parse($get('date_start'))->startOfDay(),
                        //                     Carbon::parse($get('date_end'))->endOfDay(),
                        //                 ]);
                        //             });
                        //         })
                        //         ->whereHas('card.records')->select(DB::raw("CONCAT(last_name, ' ', first_name, ' ', middle_name, ' - ', account_type) AS full_name"), 'id')->pluck('full_name', 'id')->toArray();
                        //     })
                        //     ->columnSpan(2)
                        //     ->searchable()
                        //     ->label('Full name')
                        //     ->live()
                        //     ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        //         $this->account = Account::where('id', $state)->first();
                        //         if (!empty($state) && !empty($get('date_start')) && !empty($get('date_end'))) {


                        //             $this->records = Record::orderBy('created_at', 'desc')
                        //                 ->when($state, function ($query) use ($state) {
                        //                     $query->whereHas('card', function ($query) use ($state) {
                        //                         $query->where('account_id', $state);
                        //                     });
                        //                 })
                        //                 ->when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                        //                     // Apply date range filter
                        //                     $query->whereBetween('created_at', [
                        //                         Carbon::parse($get('date_start'))->startOfDay(),
                        //                         Carbon::parse($get('date_end'))->endOfDay(),
                        //                     ]);
                        //                 })
                        //                 ->get();
                        //         } else {
                        //             $this->records = [];
                        //         }
                        //     })->searchable(),

                        //     Flatpickr::make('date_start')


                        //     ->live()
                        //     ->columnSpan(2)
                        //     ->dateFormat('F d, Y')
                        //     ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        //         $this->date_start = $state;

                        //         if (!empty($get('name')) && (!empty($state) || !empty($get('date_end')))) {
                        //             // Only query data if name is selected and either date_start or date_end is not empty
                        //             $data = Record::orderBy('created_at', 'desc')
                        //                 ->when($state && !empty($get('date_end')), function ($query) use ($state, $get) {
                        //                     // Apply date range filter using date_start and date_end
                        //                     $query->whereBetween('created_at', [
                        //                         Carbon::parse($state)->startOfDay(),
                        //                         Carbon::parse($get('date_end'))->endOfDay(),
                        //                     ]);
                        //                 })
                        //                 ->when(empty($get('date_end')) && !empty($state), function ($query) use ($state) {
                        //                     // Apply date_start filter only if date_end is empty and date_start is not empty
                        //                     $query->whereDate('created_at', Carbon::parse($state)->format('Y-m-d'));
                        //                 })
                        //                 ->when(empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                        //                     // Apply date_end filter only if date_start is empty and date_end is not empty
                        //                     $query->whereDate('created_at', Carbon::parse($get('date_end'))->format('Y-m-d'));
                        //                 })
                        //                 ->get();

                        //             $this->records = $data;
                        //         } else {
                        //             $this->records = [];
                        //         }
                        //     }),

                        // Flatpickr::make('date_end')

                        //     ->dateFormat('F d, Y')
                        //     ->live()
                        //     ->columnSpan(2)
                        //     ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        //         $this->date_end = $state;

                        //         if (!empty($get('name')) && (!empty($state) || !empty($get('date_start')))) {
                        //             // Only query data if name is selected and either date_start or date_end is not empty
                        //             $data = Record::orderBy('created_at', 'desc')
                        //                 ->when($state && !empty($get('date_start')), function ($query) use ($state, $get) {
                        //                     // Apply date range filter using date_start and date_end
                        //                     $query->whereBetween('created_at', [
                        //                         Carbon::parse($get('date_start'))->startOfDay(),
                        //                         Carbon::parse($state)->endOfDay(),
                        //                     ]);
                        //                 })
                        //                 ->when(empty($get('date_start')) && !empty($state), function ($query) use ($state) {
                        //                     // Apply date_end filter only if date_start is empty and date_end is not empty
                        //                     $query->whereDate('created_at', Carbon::parse($state)->format('Y-m-d'));
                        //                 })
                        //                 ->when(empty($get('date_end')) && !empty($get('date_start')), function ($query) use ($get) {
                        //                     // Apply date_start filter only if date_end is empty and date_start is not empty
                        //                     $query->whereDate('created_at', Carbon::parse($get('date_start'))->format('Y-m-d'));
                        //                 })
                        //                 ->get();

                        //             $this->records = $data;
                        //         } else {
                        //             $this->records = [];
                        //         }
                        //     }),





                        Select::make('name')

                            ->options(function (Get $get, Set $set, $state) {
                                return Account::when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                                    $query->whereHas('card.records', function ($query) use ($get) {
                                        $query->whereBetween('created_at', [
                                            Carbon::parse($get('date_start'))->startOfDay(),
                                            Carbon::parse($get('date_end'))->endOfDay(),
                                        ]);
                                    });
                                })
                                    ->whereHas('card.records')->select(DB::raw("CONCAT(last_name, ' ', first_name, ' ', middle_name, ' - ', account_type) AS full_name"), 'id')->pluck('full_name', 'id')->toArray();
                            })

                            ->columnSpan(2)
                            ->searchable()
                            ->label('Full name')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {

                                $this->account = Account::where('id', $state)->first();
                                if (!empty($state) && (!empty($get('date_start')) || !empty($get('date_end')))) {
                                    $data = Record::orderBy('created_at', 'desc')
                                        ->when($state, function ($query) use ($state) {
                                            $query->whereHas('card', function ($query) use ($state) {
                                                $query->where('account_id', $state);
                                            });
                                        })
                                        ->when(!empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                                            $query->whereBetween('created_at', [
                                                Carbon::parse($get('date_start'))->startOfDay(),
                                                Carbon::parse($get('date_end'))->endOfDay(),
                                            ]);
                                        })
                                        // ->when(!empty($get('period')), function ($query) use ($get) {
                                        //     // Apply period filter
                                        //     $timeCondition = $get('period') == 'am' ? '<' : '>=';
                                        //     $query->whereTime('created_at', $timeCondition, '12:00:00');
                                        // })
                                        ->get();
                                    $this->records = $data;
                                } else {
                                    $this->records = [];
                                }
                            }),

                        DatePicker::make('date_start')
                            ->native(false)
                            ->live()
                            ->columnSpan(2)
                            // ->dateFormat('F d, Y')
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {

                                $this->date_start =  Carbon::parse($state)->isoFormat('MMMM DD, YYYY');
                                if (!empty($get('name')) && (!empty($state) || !empty($get('date_end')))) {
                                    $data = Record::orderBy('created_at', 'desc')
                                        ->when($state && !empty($get('date_end')), function ($query) use ($state, $get) {
                                            $query->whereBetween('created_at', [
                                                Carbon::parse($state)->startOfDay(),
                                                Carbon::parse($get('date_end'))->endOfDay(),
                                            ]);
                                        })
                                        ->when(empty($get('date_end')) && !empty($state), function ($query) use ($state) {
                                            $query->whereDate('created_at', Carbon::parse($state)->format('Y-m-d'));
                                        })
                                        ->when(empty($get('date_start')) && !empty($get('date_end')), function ($query) use ($get) {
                                            $query->whereDate('created_at', Carbon::parse($get('date_end'))->format('Y-m-d'));
                                        })

                                        ->get();
                                    $this->records = $data;
                                } else {
                                    $this->records = [];
                                }
                            })
                            ->label('Date Start'),

                        DatePicker::make('date_end')
                            ->native(false)
                            // ... Other options

                            ->live()
                            ->columnSpan(2)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $this->date_end = Carbon::parse($state)->isoFormat('MMMM DD, YYYY');
                                if (!empty($get('name')) && (!empty($state) || !empty($get('date_start')))) {
                                    $data = Record::orderBy('created_at', 'desc')
                                        ->when($state && !empty($get('date_start')), function ($query) use ($state, $get) {
                                            $query->whereBetween('created_at', [
                                                Carbon::parse($get('date_start'))->startOfDay(),
                                                Carbon::parse($state)->endOfDay(),
                                            ]);
                                        })
                                        ->when(empty($get('date_start')) && !empty($state), function ($query) use ($state) {
                                            $query->whereDate('created_at', Carbon::parse($state)->format('Y-m-d'));
                                        })
                                        ->when(empty($get('date_end')) && !empty($get('date_start')), function ($query) use ($get) {
                                            $query->whereDate('created_at', Carbon::parse($get('date_start'))->format('Y-m-d'));
                                        })

                                        ->get();
                                    $this->records = $data;
                                } else {
                                    $this->records = [];
                                }
                            })->label('Date End'),



                        // Flatpickr::make('time_start')->time()
                        TimePicker::make('time_start')
                            ->seconds(false)
                            ->live()
                            ->columnSpan(2)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {

                                // dd($state);
                                $this->time_start = $state;


                                $data = Record::orderBy('created_at', 'desc')
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

                                $data = Record::orderBy('created_at', 'desc')
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


                        //  TimePicker::make('time_end')
                        // ->seconds(false)
                        // ->live()
                        // ->columnSpan(2)
                        // ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        //     $this->time_end = $state;


                        //     $data= Record::orderBy('created_at', 'desc')->get();
                        //     $this->records = $data;


                        // }),














                    ]),


            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.individual-report');
    }
}
