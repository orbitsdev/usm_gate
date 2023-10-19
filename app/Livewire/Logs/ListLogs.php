<?php

namespace App\Livewire\Logs;

use App\Models\Log;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
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

class ListLogs extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Log::query())
            ->columns([
                // TextColumn::make('card_id')
                //       ->numeric()
                //       ->sortable()
                //       ->label('card_id')
                //       ,
              TextColumn::make('card.id_number')
                    ->numeric()
                    ->sortable(),
              TextColumn::make('source')
                    ->searchable(),
              TextColumn::make('transaction')
                    ->searchable(),
              TextColumn::make('message')
                    ->searchable(),
              TextColumn::make('error_type')
                    ->searchable(),
              TextColumn::make('created_at')
                 ->date(),
              TextColumn::make('updated_at')
                 ->date(),
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
        return view('livewire.logs.list-logs');
    }
}
