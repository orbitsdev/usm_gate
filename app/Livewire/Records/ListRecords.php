<?php

namespace App\Livewire\Records;

use App\Models\Day;
use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListRecords extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public $day_id;
    public $day;

    public function mount($day)
    {
        $this->day_id = $day;
        $this->day = Day::find($day);
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
            ->modifyQueryUsing(
                fn (Builder $query) => $query->when($this->day_id, function ($query) {
                    $query->where('day_id', $this->day_id);
                })
            )
            ->columns([

                // TextColumn::make('purpose.title')
                //     ->searchable(),
                // TextColumn::make('doord_id')
                //     ->searchable(),
                TextColumn::make('card.account')->label('Account')->formatStateUsing(function ($record) {
                    return $record->card->account->first_name . ' ' . $record->card->account->last_name;
                })->searchable(),

                TextColumn::make('card.id_number')->label('Card ID')->searchable(),
                TextColumn::make('door_entered')->label('Door Entered')->searchable(),
                TextColumn::make('door_exit')->label('Door Exited')->searchable(),

                // IconColumn::make('entry')
                //     ->label('Entered')
                //     ->boolean(),
                // IconColumn::make('exit')
                //     ->label('Exit')
                //     ->boolean(),

                TextColumn::make('created_at')->label('Time Enter')->formatStateUsing(function ($record) {

                    if ($record->entry) {

                        return $record->created_at->format('h:i:s A');
                    } else {
                        'None';
                    }
                })
                ->badge()
                ->color('success')
                ,

                TextColumn::make('updated_at')
                    ->label('Time out')
                    ->formatStateUsing(function ($record) {

                        if ($record->entry == true && $record->exit == true) {

                            return $record->updated_at->format('h:i:s A');
                        } else {
                            return '-- No Exit -- ';
                        }
                    })
                    ->badge()
                    ->color('danger')
                    ,

            ])
            ->filters([
                // SelectFilter::make('purpose')->relationship('purpose', 'title')->searchable()->preload()->multiple(),

                // Filter::make('entry')
                //     ->toggle(),
                // Filter::make('exit')
                //     ->toggle()
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
            ->poll('1s');;
    }

    public function render(): View
    {
        return view('livewire.records.list-records');
    }
}
