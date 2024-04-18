<?php

namespace App\Livewire\Transactions;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
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

                TextColumn::make('door_name')
                ->searchable(isIndividual: true, isGlobal: false)
                ->label('Door')->color('primary')->badge(),
               

                TextColumn::make('card.id_number')
                ->searchable(isIndividual: true, isGlobal: true)
                ->label('Card ID'),
                TextColumn::make('card.qr_number')
                ->searchable(isIndividual: true, isGlobal: true)
                ->label('QR Number'),

                
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
                }
            ,isIndividual: true, isGlobal: true
            ),
            TextColumn::make('error_type')
                ->copyable()
                    ->label('Error')
                    ->badge()
                    ->color('danger')
                    ->searchable(
                        isIndividual: true, isGlobal: false
                    )
                    ,
                TextColumn::make('message')
                ->wrap()
                ->label('Message')
               
                ,
            
                
                
                
                    
              

                 
                 
                
              
                    TextColumn::make('scanned_type')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                    ->label('Scanned At')
                    ,

                TextColumn::make('source')->searchable()->label('Source')
                ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                ,
                
              


                TextColumn::make('created_at')
                    ->date('M d, Y  h:i:s A'),
              
                TextColumn::make('updated_at')
                ->date('M d, Y  h:i:s A'),
                    
            ])
            ->filters([
                //
            ])
            ->actions([

                  
                Action::make('view')
                ->color('primary')
                ->icon('heroicon-m-eye')
                ->button()
                ->outlined()
                ->label('Card Details')
                ->modalContent(function (Transaction $record) {
                    
                    return view('livewire.card-details', ['record' => $record->card]);
                })
                ->modalHeading('Card Details')
                ->modalSubmitAction(false)
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->disabledForm()
                // ->slideOver()
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->hidden(function(Model $record){
                    if(empty($record->card)){
                        return true;
                    }else{
                        return false;
                    }
                })
                ,
                DeleteAction::make()->button()->outlined(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),
            ])
            ->groups([
                Group::make('card_id')
                ->titlePrefixedWithLabel(false)
              ->getTitleFromRecordUsing(function (Transaction $record) {
                  $card = $record->card ?? null;
                  $account = optional($card)->account ?? null;
          
                  return $account
                      ? $account->first_name . ' ' . $account->last_name
                      : 'Unknown';
              })
              ->label('Card Owner'),
                Group::make('card.id_number')
                ->label('Card ID')
                
                // ->titlePrefixedWithLabel(false)
                ->collapsible()
                ,
                Group::make('door_name')
                ->titlePrefixedWithLabel(false)
                ->label('Door Name')
                ,
                Group::make('error_type')
                ->titlePrefixedWithLabel(false)
                ->label('Error Type')
                ,
                

              
            


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
