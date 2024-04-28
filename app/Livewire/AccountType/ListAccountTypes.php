<?php

namespace App\Livewire\AccountType;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\AccountType;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ListAccountTypes extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(AccountType::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make('add')
               
                ->icon('heroicon-o-sparkles')
                ->label('Add New Type')
                ->form([
                    TextInput::make('name')->required()
                    ->label('Account Type')->unique()
                    

                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make('edit')
               
                // ->icon('heroicon-o-sparkles')
                ->label('Edit')
                ->form([
                    TextInput::make('name')->required()
                    ->label('Account Type')->unique()
                    

                ]),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.account-type.list-account-types');
    }
}
