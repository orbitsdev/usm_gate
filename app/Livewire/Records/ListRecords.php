<?php

namespace App\Livewire\Records;

use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListRecords extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public $day_id;

    public function mount($day){
        $this->day_id = $day;
    }

    public function deleteAction(): Action
    {
        return Action::make('back')
        ->label('Go Back')
        ->url(fn (): string => 'www.example.com'); 
    
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Record::query())
            ->modifyQueryUsing(fn (Builder $query) => $query->when($this->day_id, function($query){
                $query->where('day_id', $this->day_id);
            })
            )
            ->columns([
               
                TextColumn::make('purpose.title')
                    ->searchable(),
                TextColumn::make('doord_id')
                    ->searchable(),
                TextColumn::make('entry')
                   ->formatStateUsing(fn($state)=> $state ? 'In' : 'None'),
                TextColumn::make('exit')
                   ->formatStateUsing(fn($state)=> $state ? 'Out' : 'None'),
                TextColumn::make('created_at')->label('Time Enter')->formatStateUsing(function($record){

                        if($record->entry){

                            return $record->created_at->format('h:i A');
                        }else{
                            'None';
                        }
              
                       
        
                    }),

                    TextColumn::make('updated_at')->label('Time out')->formatStateUsing(function($record){
                        
                        if($record->entry == true && $record->exit ==true){

                            return $record->updated_at->format('h:i A');
                        }else{
                            return '-- Currently Inside -- ';
                        }
                       
        
                    }),
               
            ])
            ->filters([
                SelectFilter::make('purpose')->relationship('purpose', 'title')->searchable()->preload()->multiple(),
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
        return view('livewire.records.list-records');
    }
}
