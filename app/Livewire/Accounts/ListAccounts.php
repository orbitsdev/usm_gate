<?php

namespace App\Livewire\Accounts;

use Filament\Tables;
use App\Models\Account;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListAccounts extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static bool $canCreateAnother = false;


    // public function getTableHeaderActions(): array{
    //     return [
    //         CreateAction::make('add'),
    //     ];
    // }
    public function table(Table $table): Table
    {
        return $table
            ->query(Account::query()->latest())
            ->columns(
                [   
                   TextColumn::make('first_name')
                        ->searchable(),
                   TextColumn::make('last_name')
                        ->searchable(),
                   TextColumn::make('middle_name')
                        ->searchable(),
                   TextColumn::make('sex')
                        ->searchable(),
                   TextColumn::make('birth_date')
                        ->date()
                        ->sortable(),
                   TextColumn::make('contact_number')
                        ->searchable(),
                        ImageColumn::make('image')
                        ->width(60)->height(60)
                        ->url(fn (Account $record): null|string => $record->image ?  Storage::disk('public')->url($record->image) : null)
                        
                        ->openUrlInNewTab()

                        ,

                ],

            )
            ->headerActions([
                CreateAction::make('add')->form([
                    TextInput::make('first_name')->required(),
                    TextInput::make('last_name')->required(),
                    TextInput::make('middle_name')->required(),
                    TextInput::make('sex')->required(),
                    DatePicker::make('birth_date')->required()->label('Birth date')
                    ->timezone('Asia/Manila')
                    ->closeOnDateSelection()->required(),
                    TextInput::make('contact_number'),
                    FileUpload::make('image')
                    ->disk('public')
                    ->directory('accounts')
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(2)
                    ->required()
                ])
                ->modalWidth('6xl')
                ->createAnother(false)
                


            ])
            

            ->filters([
                SelectFilter::make('sex')
                    ->options([

                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
            ])
            ->actions(
                [
                    ActionGroup::make([
                        EditAction::make()->form([
                            TextInput::make('first_name'),
                            TextInput::make('last_name'),
                            TextInput::make('middle_name'),
                        ]),
                        DeleteAction::make(),
                    ]),
                ],
                position: ActionsPosition::BeforeCells,
            )
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
        return view('livewire.accounts.list-accounts');
    }
}
