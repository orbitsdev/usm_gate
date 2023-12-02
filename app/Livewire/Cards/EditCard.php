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
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms\Components\DatePicker;

class EditCard extends Component implements HasForms, HasActions
{   
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public Card $record;
    

    public function mount($card): void
    {   

        $this->record = Card::find($card);
        $data = $this->record->attributesToArray();
        // dd($data);
        $this->form->fill($data);
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
                        '2xl' => 12,
                    ])
                    ->schema([
                        Select::make('account_id')
                       
                        ->relationship(
                                name: 'account',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                            ->searchable(['account.first_name', 'account.last_name'])
                            ->preload()
                            ->label('Select Account')
                            ->columnSpanFull(),
                          
                            
                        TextInput::make('id_number')->required()->unique(ignoreRecord: true)
                        ->columnSpan(3)
                        ->label('Card ID')
                        ,   
                        TextInput::make('qr_number')->required()->unique(ignoreRecord: true)
                        ->columnSpan(3)
                        ->label('Qr Number')
                        ,   
                        DatePicker::make('valid_from')
                        ->required()
                        ->native(false)
                        
                        ->columnSpan(3),
                        DatePicker::make('valid_until')
                        ->required()

                        ->label('Card Until')
                        ->native(false)



                        ->columnSpan(3)
                        ,
    
                        Select::make('status')
                        ->label('Card Status')
                        ->options([
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                            'Blocked' => 'Blocked',
                            'Expired' => 'Expired',
                        ])
                        ->default('Active')
                        ->columnSpanFull()
                        ->required()
                        ]),
            ])
            ->statePath('data')
            ->model($this->record);
    }


    public function submitAction(): Action
    {
        return Action::make('submit')
        ->label('Save Update')
            ->action(function () {
             
                
                $data = $this->form->getState();
                $this->record->update($data);


                $this->form->fill();
                
                return redirect()->route('cards');
            });
    }
    public function back(): Action
    {
        return Action::make('back')
        ->color('gray')
        ->url(fn (): string => route('cards'));
    }

    // public function edit(): void
    // {
    //     $data = $this->form->getState();

    //     $this->record->update($data);
    // }

    public function render(): View
    {
        return view('livewire.cards.edit-card');
    }
}