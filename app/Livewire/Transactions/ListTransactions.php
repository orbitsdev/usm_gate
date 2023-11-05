<?php

namespace App\Livewire\Transactions;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
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
                // TextColumn::make('card')->searchable()
                // ->formatStateUsing(function($record){
                //     $firstName = $record->card && $record->card->account && $record->card->account->first_name
                //     ? $record->card->account->first_name
                //     : 'Unknown';
                
                // $lastName = $record->card && $record->card->account && $record->card->account->last_name
                //     ? $record->card->account->last_name
                //     : 'Unknown';
                
                // return $firstName . ' - ' . $lastName;
                
                // })
                // ->label('Account'),
              
                IconColumn::make('success')
                ->sortable()
                ->boolean()
                ->label('Success')
                ,

                TextColumn::make('door_name')->searchable()->label('Door')->color('primary')->badge(),

                TextColumn::make('card.id_number')->searchable()
                ->label('Card ID'),

                
                TextColumn::make('card.account')->label('Card Owner')->formatStateUsing(function (Transaction $record) {
                    $first_name =  $record->card->account->first_name ?? '';
                    $last_name =  $record->card->account->last_name.',' ?? '';
                
                    return ucfirst($last_name) . '  ' . ucfirst($first_name);
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('card.account', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                }),

                TextColumn::make('message')
                ->wrap()
                ->label('Message')
                ,
            
                
                
                
                    
              

                 
                    TextColumn::make('scanned_type')
                    ->sortable()
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                    ->label('Scanned At')
                    ,
                TextColumn::make('error_type')
                ->copyable()
                    ->label('Error')
                    ->badge()
                   
                    ->color('danger')
                    ,
              
               

                TextColumn::make('source')->searchable()->label('Source')
                ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                ,
                
              


                TextColumn::make('created_at')
                    ->dateTime(),
              
                TextColumn::make('updated_at')
                    ->dateTime(),
                    
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make()->button()->outlined(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => 
            // $query->whereHas('patient.animal.user', function($query){
            //     $query->where('id', auth()->user()->id);
            // })

            $query->latest(),
            
            )
            ->poll('2s');
    }

    public function render(): View
    {
        return view('livewire.transactions.list-transactions');
    }
}
