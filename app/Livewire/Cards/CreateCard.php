<?php

namespace App\Livewire\Cards;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Card;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

use Filament\Notifications\Notification;

class CreateCard extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }
  
    public function back(): Action
    {
        return Action::make('back')
        ->color('gray')
        ->url(fn (): string => route('cards'));
    }

    public function submitAction(): Action
    {
        return Action::make('submit')
        ->label('Save Card')
            ->action(function () {
             
                
                // dd($this->form->getState());
                // redirect()->route('cards');
                $data = $this->form->getState();

                $data['valid_from'] = Carbon::parse($data['valid_from'])->format('Y-m-d');
                $data['valid_until'] = Carbon::parse($data['valid_until'])->format('Y-m-d');               
                $record = Card::create($data);
                
                $this->form->model($record)->saveRelationships();

            //     Notification::make()
            // ->title('Saved successfully')
            // ->success()
            // ->send();
                
            $this->form->fill();
                return redirect()->route('cards');
            });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->description('Card Information')
                    ->icon('heroicon-m-identification')
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 9,
                    ])
                    ->schema([
                        Select::make('account_id')
                            ->label('Select Account')
                            ->relationship(
                                name: 'account',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) . ', ' . ucfirst(optional($record)->first_name))
                            ->searchable(['account.first_name', 'account.last_name'])
                            ->preload()
                            ->label('Account')
                            ->columnSpanFull()
                            ->relationship(
                                                name: 'account',
                                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                                            )
                                            ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                                            ->searchable(['account.first_name', 'account.last_name'])
                                            ->preload()
                                            ->label('Account')
                                            ->columnSpanFull()
                
                                            ->createOptionForm([
                                                Section::make()
                                                ->description('Personal Information')
                                                ->icon('heroicon-m-user')
                                                ->columns([
                                                    'sm' => 3,
                                                    'xl' => 6,
                                                    '2xl' => 9,
                                                ])
                                                ->schema([
                                                    Select::make('account_type')
                                                        ->options([
                                                            'Student' => 'Student',
                                                            'Staff' => 'Staff',
                                                            'Teacher' => 'Teacher',
                                                        ])
                                                        ->required()
                                                        ->native(false)
                                                        ->columnSpanFull()
                                                        ->label('Account Type'),
                                                    TextInput::make('first_name')->required()->columnSpan(3),
                                                    TextInput::make('middle_name')->required()->columnSpan(3),
                                                    TextInput::make('last_name')->required()->columnSpan(3),
                                                    Select::make('sex')
                                                        ->options([
                                                            'Male' => 'Male',
                                                            'Female' => 'Female',
                                                        ])->columnSpan(3),
                        
                                                    DatePicker::make('birth_date')->required()->label('Birth date')
                                                        ->timezone('Asia/Manila')
                                                        ->closeOnDateSelection()->required()
                                                        ->columnSpan(3)
                                                        ->native(false),
                                                    TextInput::make('contact_number')
                                                        ->columnSpan(3)
                                                        ->maxLength(10)
                                                        ->prefix('+63'),
                        
                                                        Textarea::make('address')
                                                        ->rows(3)
                                                        ->columnSpanFull(),
                                                    FileUpload::make('image')
                                                        ->disk('public')
                                                        ->directory('accounts')
                                                        ->image()
                                                        ->imageEditor()
                                                        ->imageEditorMode(2)
                                                        ->required()
                                                        ->columnSpanFull()
                                                ])->columnSpanFull(),
                        
                                                
                                                        ],
                                                        )
                            ,


                        TextInput::make('id_number')->required()->unique(ignoreRecord: true)
                            ->columnSpan(3)
                            ->label('Card ID'),
                        DatePicker::make('valid_from')
                        ->native(false)
                        ->required()

                            ->label('Valid From')

                            ->columnSpan(3),
                        DatePicker::make('valid_until')
                        ->required()
                        ->native(false)
                            ->label('Valid Until')
                                                        
                            ->columnSpan(3),

                        Select::make('status')
                            ->label('Card Status')
                            ->options([
                                'Active' => 'Active',
                                'InActive' => 'Inactive',
                                'Blocked' => 'Blocked',
                                'Expired' => 'Expired',
                            ])
                            ->default('Active')
                            ->columnSpanFull()
                            ->required()
                    ]),
            ])
            ->statePath('data')
            ->model(Card::class);
    }

    public function create(): void
    {


        $data = $this->form->getState();

        $record = Card::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.cards.create-card');
    }
}
