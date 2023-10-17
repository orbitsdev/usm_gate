<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListCard extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Card::query())
            ->columns([
                Tables\Columns\TextColumn::make('account_id')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_number')
                ->searchable()
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_from')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state)=> ucfirst($state))
                    ->searchable(),
               
            ])
            ->headerActions([
                CreateAction::make('add')->form([
                    TextInput::make('id_number'),

                    Select::make('status')
                    ->label('Card Status')
                    ->options([
                        'Active' => 'Active',
                        'InActive' => 'InActive',
                        'Block' => 'Block',
                        'Expired' => 'Expored',
                    ])
                    ->required(),
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
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.cards.list-card');
    }
}
