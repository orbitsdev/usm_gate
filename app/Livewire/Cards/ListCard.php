<?php

namespace App\Livewire\Cards;

use App\Models\Card;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Exports\CardsExport;
use App\Imports\CardsImport;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
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
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class ListCard extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Card::query()->latest())
            ->columns([

                TextColumn::make('account_id')->label('Card Owner')->formatStateUsing(function (Card $record) {
                    return ucfirst($record->account?->last_name) . ', ' .ucfirst($record->account?->first_name). ' '.ucfirst($record->account?->middle_name);
                })
               
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('account', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                })
                ,
               TextColumn::make('id_number')
               ->copyable()
                ->searchable()

                    ->sortable(),
               TextColumn::make('valid_from')
               
               ->date()

                    ->sortable(),
               TextColumn::make('valid_until')
               ->date()
                    ->sortable(),

               TextColumn::make('status')
                   
                    ->formatStateUsing(fn($state)=> ucfirst($state))
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {

                        'Active' => 'success',
                        'Inactive' => 'gray',
                        'Blocked' => 'danger',
                        'Expired' => 'danger',
                        default=> 'gray',

                    
                    })
                ->icon(fn (string $state): string => match ($state) {

                    'Active' => 'heroicon-o-check',
                    'Inactive' => 'heroicon-o-ellipsis-horizontal-circle',
                    'Blocked' => 'heroicon-o-no-symbol',
                    'Expired' => 'heroicon-o-x-mark',
                    default => 'heroicon-o-clock'

                })
                    ,

                    TextColumn::make('id')->label('ID'),

            ],)
            ->headerActions([

                Action::make('Import ')->button()->action(function (array $data): void {

                    $file  = Storage::disk('public')->path($data['file']);
                   
                    Excel::import(new CardsImport, $file);
    
                    if (Storage::disk('public')->exists($data['file'])) {
    
                        Storage::disk('public')->delete($data['file']);
                    }
                })->icon('heroicon-o-arrow-up-tray')->form([
                    FileUpload::make('file')->acceptedFileTypes(['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/csv', 'text/csv', 'text/plain'])->disk('public')->directory('imports')
                    ->label('Excel File')
                ])
                ->outlined()
                ->button()
                ->label('Import')
                ->modalHeading("Import to Create or Update Cards")
            
                ,

                Action::make('Export')->button()->action(function(array $data) {
              
                
                    // return Excel::download(new UserExport, 'invoices.xlsx');
                    $filename = now()->format('Y-m-d');
                    return Excel::download(new CardsExport, $filename.'-CARDS.xlsx');
    
                })
                ->outlined()
                ->button()
                ->icon('heroicon-o-arrow-down-tray')
                ->requiresConfirmation()->modalHeading('Export Card')
                ->modalHeading('Download Excel as Report or Reference')
                ->button('Yes')
                ->label('Download')
                ,
                
                CreateAction::make('add')
                ->label('New Card')
                ->icon('heroicon-o-sparkles')
                ->form([

                    Section::make()
                    ->description('Card Information')
                    ->icon('heroicon-m-identification')
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 9,
                    ])
                    ->schema([
                        Select::make('account_id')
                        ->label('Select Account')
                        ->relationship(
                                name: 'account',
                                modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                            ->searchable(['account.first_name', 'account.last_name'])
                            ->preload()
                            ->label('Account')
                            ->columnSpanFull()

                            // ->createOptionForm([
                            //     Section::make()
                            //     ->description('Personal Information')
                            //     ->icon('heroicon-m-user')
                            //     ->columns([
                            //         'sm' => 3,
                            //         'xl' => 6,
                            //         '2xl' => 9,
                            //     ])
                            //     ->schema([
                            //         Select::make('account_type')
                            //             ->options([
                            //                 'Student' => 'Student',
                            //                 'Teacher' => 'Teacher',
                            //             ])
                            //             ->required()
                            //             ->native(false)
                            //             ->columnSpanFull()
                            //             ->label('Account Type'),
                            //         TextInput::make('first_name')->required()->columnSpan(3),
                            //         TextInput::make('middle_name')->required()->columnSpan(3),
                            //         TextInput::make('last_name')->required()->columnSpan(3),
                            //         Select::make('sex')
                            //             ->options([
                            //                 'Male' => 'Male',
                            //                 'Female' => 'Female',
                            //             ])->columnSpan(3),
        
                            //         DatePicker::make('birth_date')->required()->label('Birth date')
                            //             ->timezone('Asia/Manila')
                            //             ->closeOnDateSelection()->required()
                            //             ->columnSpan(3)
                            //             ->native(false),
                            //         TextInput::make('contact_number')
                            //             ->columnSpan(3)
                            //             ->maxLength(10)
                            //             ->prefix('+63'),
                            //         FileUpload::make('image')
                            //             ->disk('public')
                            //             ->directory('accounts')
                            //             ->image()
                            //             ->imageEditor()
                            //             ->imageEditorMode(2)
                            //             ->required()
                            //             ->columnSpanFull()
                            //     ])->columnSpanFull(),
                            // ])
                            ,
                            
                        TextInput::make('id_number')->required()->unique(ignoreRecord: true)
                        ->columnSpan(3)
                        ->label('Card ID')
                        ,   
                        Flatpickr::make('valid_from')
                        ->label('Valid From')

                        ->columnSpan(3),
                        Flatpickr::make('valid_until')
                        ->label('Card Until')

                        ->columnSpan(3)
                        ,
    
                        Select::make('status')
                        ->label('Card Status')
                        ->options([
                            'Active' => 'Active',
                            'InActive' => 'Inactive',
                            'Blocked' => 'Blocked',
                            'Expired' => 'Expired',
                        ])
                        ->default('Active')
                        ->columnSpanFull()
                        ->required()
                    ]),

                   
                    // TextInput::make('middle_name'),
                    // TextInput::make('sex'),

                ])
                ->modalWidth('6xl')
                ->createAnother(false)



            ])
            ->filters([
                SelectFilter::make('status')
                ->options([

                    'Active' => 'Active',
                    'Inactive' => 'Inactive',
                    'Blocked' => 'Blocked',
                    'Expired' => 'Expired',
                ])
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                    ->mutateRecordDataUsing(function (Model $record, array $data): array {
                        // $data['account_id'] = auth()->id();
                 
                        return $data;
                    })
                    ->form([
                        
                        
                            
                        Section::make()
                        ->description('Card Information')
                        ->icon('heroicon-m-identification')
                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 9,
                        ])
                        ->schema([
                            Select::make('account_id')
                            ->label('Select Account')
                            ->relationship(
                                    name: 'account',
                                    modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('card')
                                )
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => ucfirst(optional($record)->last_name) .', '. ucfirst(optional($record)->first_name)  )
                                ->searchable(['account.first_name', 'account.last_name'])
                                ->preload()
                                ->label('Account')
                                ->columnSpanFull()
                                ->hidden(function (Model $record){
                                    return $record->account;
                                })
                             

    
                                // ->createOptionForm([
                                //     Section::make()
                                //     ->description('Personal Information')
                                //     ->icon('heroicon-m-user')
                                //     ->columns([
                                //         'sm' => 3,
                                //         'xl' => 6,
                                //         '2xl' => 9,
                                //     ])
                                //     ->schema([
                                //         Select::make('account_type')
                                //             ->options([
                                //                 'Student' => 'Student',
                                //                 'Teacher' => 'Teacher',
                                //             ])
                                //             ->required()
                                //             ->native(false)
                                //             ->columnSpanFull()
                                //             ->label('Account Type'),
                                //         TextInput::make('first_name')->required()->columnSpan(3),
                                //         TextInput::make('middle_name')->required()->columnSpan(3),
                                //         TextInput::make('last_name')->required()->columnSpan(3),
                                //         Select::make('sex')
                                //             ->options([
                                //                 'Male' => 'Male',
                                //                 'Female' => 'Female',
                                //             ])->columnSpan(3),
            
                                //         DatePicker::make('birth_date')->required()->label('Birth date')
                                //             ->timezone('Asia/Manila')
                                //             ->closeOnDateSelection()->required()
                                //             ->columnSpan(3)
                                //             ->native(false),
                                //         TextInput::make('contact_number')
                                //             ->columnSpan(3)
                                //             ->maxLength(10)
                                //             ->prefix('+63'),
                                //         FileUpload::make('image')
                                //             ->disk('public')
                                //             ->directory('accounts')
                                //             ->image()
                                //             ->imageEditor()
                                //             ->imageEditorMode(2)
                                //             ->required()
                                //             ->columnSpanFull()
                                //     ])->columnSpanFull(),
                                // ])
                                ,
                                
                            TextInput::make('id_number')->required()->unique(ignoreRecord: true)
                            ->columnSpan(3)
                            ->label('Card ID')
                            ,   
                            Flatpickr::make('valid_from')
                            ->label('Valid From')
    
                            ->columnSpan(3),
                            Flatpickr::make('valid_until')
                            ->label('Card Until')
    
                            ->columnSpan(3)
                            ,
        
                            Select::make('status')
                            ->label('Card Status')
                            ->options([
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                                'Blocked' => 'Blocked',
                                'Expired' => 'Expired',
                            ])
                            ->default('Active')
                            ->columnSpanFull()
                            ->required()
                        ]),
                    ])
                    ->modalWidth('6xl')
                    ,
                    DeleteAction::make(),
                ]),
            ],
            // position: ActionsPosition::BeforeColumns
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),
            ])
            ->defaultGroup('status')
            ->groups([
                Group::make('status')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn (Card $record): string => $record->status ?  ucfirst($record->status) : '')
                    ->label('Status'),


            ])
            ;
    }

    public function render(): View
    {
        return view('livewire.cards.list-card');
    }
}
