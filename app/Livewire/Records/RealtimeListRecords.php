<?php

namespace App\Livewire\Records;

use App\Models\Day;
use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class RealtimeListRecords extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $day;
    public $latestRecord;
    public function mount(){
        $this->day = Day::latest()->first();

      
      

       
    //    if($this->day){
    //        $this->latestRecord = Record::latest()->first();           
    //     }
    //     else{
    //         Day::latest()->first();
    //    }
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Record::query())
        
            ->columns([

                TextColumn::make('day.created_at')->date(),
                TextColumn::make('card.account')->label('Account')->formatStateUsing(function ($record){ 
                    return $record->card->account->first_name . ' ' . $record->card->account->last_name;
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('card.account', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });},
                    isIndividual: true, isGlobal: true
                ),

                TextColumn::make('card.id_number')->label('Card ID')
                ->searchable(isIndividual: true, isGlobal: true),
                TextColumn::make('door_entered')->label('Entered Source ')->searchable(),
                TextColumn::make('door_exit')->label('Exited Source')->searchable(),

                // TextColumn::make('entry')
                //    ->formatStateUsing(fn($state)=> $state ? 'In' : 'None'),
                // TextColumn::make('exit')
                //    ->formatStateUsing(fn($state)=> $state ? 'Out' : 'None'),
                // IconColumn::make('entry')
                // ->label('Entered')
                //      ->boolean(),
                // IconColumn::make('exit')
                // ->label('Exit')
 
                //      ->boolean(),
                TextColumn::make('created_at')->label('Time Enter')->formatStateUsing(function($record){

                        if($record->entry){

                            return $record->created_at->format('h:i:s A');
                        }else{
                            'None';
                        }
              
                       
        
                    })
                    ->color('success')
                    ->badge()

                    ,

                    TextColumn::make('updated_at')->label('Time out')->formatStateUsing(function($record){
                        
                        if($record->entry == true && $record->exit ==true){

                            return $record->updated_at->format('h:i:s A');
                        }else{
                            return '-- NO EXIT -- ';
                        }
                       
        
                    })
                    ->badge()
                    ->color('danger')
                    ,
               
             
              
            ])
            ->filters([
                
            ])
            ->actions([

                Action::make('view')
                ->button()
                ->outlined()
                ->color('primary')
                ->icon('heroicon-m-eye')
                ->label('View Details')
                ->modalContent(function (Record $record) {
                    return view('livewire.record-details', ['record' => $record]);
                })
                ->modalHeading('Record Details')
                ->modalSubmitAction(false)
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->disabledForm()
                // ->slideOver()
                ->modalWidth(MaxWidth::SevenExtraLarge),
                //
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
              ->getTitleFromRecordUsing(function (Record $record) {
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

              
            


            ])
            ->modifyQueryUsing(fn (Builder $query) => 
            // $query->whereHas('patient.animal.user', function($query){
            //     $query->where('id', auth()->user()->id);
            // })

            $query->when($this->day, function($query){
                $query->where('day_id', $this->day->id);
            })->latest(),
            
            )
            
            ->poll('1s');
            
    }

    public function render(): View
    {
        return view('livewire.records.realtime-list-records');
    }
}
