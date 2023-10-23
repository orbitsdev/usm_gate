<?php

namespace App\Livewire\Records;

use App\Models\Day;
use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
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
                })->searchable(),

                TextColumn::make('card.id_number')->label('Card ID')->searchable(),
                TextColumn::make('door_entered')->label('Door Entered')->searchable(),
                TextColumn::make('door_exit')->label('Door Exited')->searchable(),

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
                            return '-- Currently Inside -- ';
                        }
                       
        
                    })
                    ->badge()
                    ->color('danger')
                    ,
               
             
              
            ])
            ->filters([
                
            ])
            ->actions([
                //
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
