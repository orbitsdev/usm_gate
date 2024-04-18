<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
               
                Tables\Columns\TextColumn::make('created_at')
                    ->date(),

               
            ])
            ->filters([
                //
            ])
            ->headerActions([ 
                CreateAction::make('add')
                ->using(function (array $data, string $model): Model {
                    
                    $data['password']= Hash::make('password');
                    

                    return $model::create($data);
                })
                ->icon('heroicon-o-sparkles')
                ->label('New Account')
                ->form([
                    

                    Section::make()
                        ->description('User Information')
                        ->icon('heroicon-m-user')
                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 9,
                        ])
                        ->schema([
                            TextInput::make('email')->required()
                            ->unique(ignoreRecord: true)
                             ->columnSpanFull(),
                            TextInput::make('name')->required()
                            ->columnSpanFull(),

                            TextInput::make('password')
                            ->label('Password')
                            ->required()
                            ->columnSpanFull()
                            ,
                          
                        ])->columnSpanFull(),


                ])
                    ->modalWidth('6xl')
                    ->createAnother(false)
             ])
            ->actions([


                
                EditAction::make()
                ->button()
                
                ->mutateRecordDataUsing(function (Model $record, array $data): array {
                    // $data['account_id'] = auth()->id();

                    return $data;
                })
                ->form([
                    Section::make()
                        ->description('User Information')
                        ->icon('heroicon-m-user')
                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 9,
                        ])
                        ->schema([
                            TextInput::make('email')->required()
                            ->unique(ignoreRecord: true)
                             ->columnSpanFull(),
                            TextInput::make('name')->required()
                            ->columnSpanFull(),

                            TextInput::make('password')
                            ->label(fn (string $operation) => $operation =='create' ? 'Password' : 'New Password')
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->columnSpanFull()
                            ,
                          
                        ])->columnSpanFull(),



                ])->modalWidth('6xl'),
                DeleteAction::make()->button()->outlined(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('email', '!=' ,'developer@gmail.com'))
            ;
    }

    public function render(): View
    {
        return view('livewire.users.list-users');
    }
}
