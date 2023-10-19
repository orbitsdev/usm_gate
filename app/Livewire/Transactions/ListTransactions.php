<?php

namespace App\Livewire\Transactions;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListTransactions extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query())
            ->columns([
                TextColumn::make('card')->searchable()
                ->formatStateUsing(function($record){
                    $firstName = $record->card && $record->card->account && $record->card->account->first_name
                    ? $record->card->account->first_name
                    : 'Unknown';
                
                $lastName = $record->card && $record->card->account && $record->card->account->last_name
                    ? $record->card->account->last_name
                    : 'Unknown';
                
                return $firstName . ' - ' . $lastName;
                
                })
                ->label('Account'),
              
                
                TextColumn::make('card_id')
                    ->sortable(),


                    TextColumn::make('card.id_number')->searchable()
                    ->label('ID number'),
                TextColumn::make('created_at')
                    ->dateTime(),
              
                TextColumn::make('updated_at')
                    ->dateTime(),
                    
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
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
        return view('livewire.transactions.list-transactions');
    }
}
