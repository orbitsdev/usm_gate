<?php

namespace App\Livewire\Records;

use App\Models\Day;
use Filament\Tables;
use App\Models\Record;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\Action as TAction;
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
                })
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('card.account', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                } ,isIndividual: true, isGlobal: true),

                TextColumn::make('card.id_number')->label('Card ID')
               
                ->searchable(isIndividual: true, isGlobal: true)
                ,
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

                TAction::make('view')
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
            ->modifyQueryUsing(fn (Builder $query) => $query->latest())
            ->poll('1s')
            
            ;
    }

    public function render(): View
    {
        return view('livewire.records.list-records');
    }
}
