<?php

namespace App\Livewire\Days;

use App\Models\Day;
use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
use App\Exports\OverAllExport;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListDays extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Day::query()->latest())
            ->columns([


                TextColumn::make('created_at')
                    ->label('Date')

                    ->date('F j, Y - l'),
                  
                TextColumn::make('records_count')
                ->counts('records')
                ->color('gray')
                ->badge()
                ->label('Total Records'),

                TextColumn::make('updated_at')
                ->label('Total No Exit Records')
                ->formatStateUsing(function(Model $record){
                    return $record->records->where('exit',false)->count();
                })




            ])
            ->filters([

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Action::make('View Records')
                ->label('View Records')
                ->color('gray')
                ->button()
                ->outlined()
                ->icon('heroicon-o-document-text')->button()
                    ->url(fn ($record): string => route('day-view-record', ['day' => $record->id])),
                    
                Action::make('Download')
                ->icon('heroicon-m-arrow-down-tray')
                ->label('Download')
                ->color('info')

                ->button()
                ->outlined()
                ->action(function($record){
                    
                    $filename = $record->created_at->format('F-d-Y');
                    $records = Record::where('day_id', $record->id)->get();
                    if(count($records)>0){
                        return Excel::download(new OverAllExport($records), $filename . '.xlsx');
                    }
                }),
                Action::make('download-no-exit')
                ->icon('heroicon-m-arrow-down-tray')
                ->label('No Exit Records')
                ->color('info')
                ->button()
                ->outlined()
                ->action(function($record){
                    
                    $filename = $record->created_at->format('F-d-Y').'-NO-EXIT';
                    $records = Record::where('day_id', $record->id)->where('exit',false)->get();
                    if(count($records)>0){
                        return Excel::download(new OverAllExport($records), $filename . '.xlsx');
                    }
                })

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),

            ])

            ->modifyQueryUsing(fn (Builder $query) => 
        
            $query->latest(),
            
            )
            
            ;
    }

    public function render(): View
    {
        return view('livewire.days.list-days');
    }
}
