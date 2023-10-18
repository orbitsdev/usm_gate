<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class ListCard extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Card::query()->latest())
            ->columns([

                TextColumn::make('account_id')->label('Card Owner')->formatStateUsing(function (Card $record) {
                    return ucfirst($record->account?->last_name) . ', ' .ucfirst($record->account?->first_name). ' '.ucfirst($record->account?->middle_name);
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('account', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                })
                ,
               TextColumn::make('id_number')
               ->copyable()
                ->searchable()

                    ->sortable(),
               TextColumn::make('valid_from')

                    ->sortable(),
               TextColumn::make('valid_until')

                    ->sortable(),

               TextColumn::make('status')
                   
                    ->formatStateUsing(fn($state)=> ucfirst($state))
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {

                        'Active' => 'success',
                        'InActive' => 'gray',
                        'Block' => 'danger',
                        'Expired' => 'danger',
                        default=> 'gray',

                    
                    })
                ->icon(fn (string $state): string => match ($state) {

                    'Active' => 'heroicon-o-check',
                    'Inactive' => 'heroicon-o-ellipsis-horizontal',
                    'Block' => 'heroicon-o-no-symbol',
                    'Expired' => 'heroicon-o-x-mark',
                    default => 'heroicon-o-clock'

                })
                    ,

            ])
            ->headerActions([
                CreateAction::make('add')->form([

                    Select::make('account_id')
                    ->label('Select Account')
                    ->relationship(
                            name: 'account',
                            modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                        )
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                        ->searchable(['account.first_name', 'account.last_name'])
                        ->preload()

                        ->label('Pet Name')


                        ,
                    TextInput::make('id_number')->required()->unique(ignoreRecord: true)
                  
                    ,
                    Flatpickr::make('valid_from'),
                    Flatpickr::make('valid_until')
                    
                    ,

                    Select::make('status')
                    ->label('Card Status')
                    ->options([
                        'Active' => 'Active',
                        'InActive' => 'InActive',
                        'Block' => 'Block',
                        'Expired' => 'Expored',
                    ])
                    ->default('Active')

                    ->required()
                    // TextInput::make('middle_name'),
                    // TextInput::make('sex'),

                ])
                ->modalWidth('6xl')
                ->createAnother(false)



            ])
            ->filters([
                SelectFilter::make('status')
                ->options([

                    'Active' => 'Active',
                    'InActive' => 'InActive',
                    'Block' => 'Block',
                    'Expired' => 'Expored',
                ])
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                    ->mutateRecordDataUsing(function (Model $record, array $data): array {
                        // $data['account_id'] = auth()->id();
                 
                        return $data;
                    })
                    ->form([
                        
                        // Select::make('account_id')
                        // ->label('Select Account')
                        // ->relationship(
                        //         name: 'account',
                        //         modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                        //     )
                        //     ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                        //     ->searchable(['account.first_name', 'account.last_name'])
                        //     ->preload()
                            
    
                        //     ->label('Owner Name')
                        //     ->disabled(true)
    
    
                        //     ,

                        TextInput::make('id_number')->required()->unique(ignoreRecord: true),
                        Flatpickr::make('valid_from'),
                        Flatpickr::make('valid_until')
                        
                        ,
    
                        Select::make('status')
                        ->label('Card Status')
                        ->options([
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                            'Block' => 'Block',
                            'Expired' => 'Expored',
                        ])
                        ->default('Active')
    
                        ->required()
                    ]),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.cards.list-card');
    }
}
