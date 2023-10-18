<?php

namespace App\Livewire\Days;

use App\Models\Day;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
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
                ->date()
                ->searchable(),

                TextColumn::make('records_count')->counts('records')->badge()->label('Record')
                    
               
            ])
            ->filters([
                
            ])
            ->actions([
                Action::make('View Records')->icon('heroicon-o-document-text')->button()
                ->url(fn ($record): string => route('day-view-record', ['day' => $record->id]))
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
        return view('livewire.days.list-days');
    }
}
