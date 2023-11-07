<?php

namespace App\Livewire\Accounts;

use Filament\Tables;
use App\Models\Account;
use Livewire\Component;
use Filament\Tables\Table;
use App\Exports\AccountExport;
use App\Imports\AccountImport;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
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
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Layout;
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
                   
                    ->label('First Name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                        ->searchable(),
                    TextColumn::make('last_name')
                    ->label('Last Name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                        ->searchable(),
                    TextColumn::make('middle_name')
                    ->label('Middle Name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                        ->searchable(),
                    TextColumn::make('sex')
                    ->label('Sex')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                        ->searchable(),
                    TextColumn::make('birth_date')
                        ->date(),


                    TextColumn::make('contact_number')
                        ->formatStateUsing(fn ($state) => $state ? '0' . $state : $state)
                        ->searchable()
                        ->copyable()
                        ->copyMessage('Copied')
                        ->copyMessageDuration(1500),
                        TextColumn::make('address')
                       ->wrap(),
                      
                    TextColumn::make('account_type')
                        ->searchable()
                      
                        ->color(fn (string $state): string => match ($state) {
                            'Student' => 'success',
                            'Staff' => 'primary',
                            default => 'info',
                        })
                        ->label('Account Type'),

                       

                        TextColumn::make('card')
                        ->formatStateUsing(fn ($state) => empty($state) ? 'No Card' : 'Has Card')
                        ->label('Card Status')
                        ->badge()
                        
                        ->color(function(string $state){
    
                            if(!empty($state)){
                                return 'success';
                            }else{
                                return 'gray';
                            }
                        })
                     
                        ,

                        ImageColumn::make('image')
                        ->label('Profile')
                        ->width(60)->height(60)
                        ->url(fn (Account $record): null|string => $record->image ?  Storage::disk('public')->url($record->image) : null)
    
                        ->openUrlInNewTab(),

                        TextColumn::make('id')->label('ID'),
                    

                ],

            )
            ->headerActions([   

                Action::make('Import ')->button()->action(function (array $data): void {

                    $file  = Storage::disk('public')->path($data['file']);
                   
                    Excel::import(new AccountImport, $file);
    
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
                ->modalHeading("Import to Create or Update Accounts. Format Must Follow. You Can Click 'Download' to See the Reference.")

            
                ,

                Action::make('Export')->button()->action(function(array $data) {
              
                
                    // return Excel::download(new UserExport, 'invoices.xlsx');
                    $filename = now()->format('Y-m-d');
                    return Excel::download(new AccountExport, $filename.'-ACCOUNTS.xlsx');
    
                })
                ->outlined()
                ->button()
                ->icon('heroicon-o-arrow-down-tray')
                ->requiresConfirmation()->modalHeading('Export Accounts')
                ->modalHeading('Download Excel as Report or Reference')
                ->button('Yes')
                ->label('Download')
                ,
                
                CreateAction::make('add')
                ->icon('heroicon-o-sparkles')
                ->label('New Account')
                ->form([
                    Section::make()
                        ->description('Personal Information')
                        ->icon('heroicon-m-user')
                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 9,
                        ])
                        ->schema([
                            Select::make('account_type')
                                ->options([
                                    'Student' => 'Student',
                                    'Staff' => 'Staff',
                                    'Teacher' => 'Teacher',
                                ])
                                ->required()
                                ->native(false)
                                ->columnSpanFull()
                                ->label('Account Type'),
                            TextInput::make('first_name')->required()->columnSpan(3),
                            TextInput::make('middle_name')->required()->columnSpan(3),
                            TextInput::make('last_name')->required()->columnSpan(3),
                            Select::make('sex')
                                ->options([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                ])->columnSpan(3),

                            DatePicker::make('birth_date')->required()->label('Birth date')
                                ->timezone('Asia/Manila')
                                ->closeOnDateSelection()->required()
                                ->columnSpan(3)
                                ->native(false),
                            TextInput::make('contact_number')
                                ->columnSpan(3)
                                ->maxLength(10)
                                ->prefix('+63'),

                                Textarea::make('address')
                                ->rows(3)
                                ->columnSpanFull(),
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('accounts')
                                ->image()
                                ->imageEditor()
                                ->imageEditorMode(2)
                                ->required()
                                ->columnSpanFull()
                        ])->columnSpanFull(),




                ])
                    ->modalWidth('6xl')
                    ->createAnother(false)



            ])


            ->filters(
                
                [
                SelectFilter::make('account_type')
                    ->options([

                        'Student' => 'Student',
                        'Staff' => 'Staff',
                        'Teacher' => 'Teacher',
                    ]),
                SelectFilter::make('sex')
                    ->options([

                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),





                ],
                )
            ->actions(
                [
                    ActionGroup::make([
                        EditAction::make()
                            ->mutateRecordDataUsing(function (Model $record, array $data): array {
                                // $data['account_id'] = auth()->id();

                                return $data;
                            })
                            ->form([
                                Section::make()
                                    ->description('Personal Information')
                                    ->icon('heroicon-m-user')
                                    ->columns([
                                        'sm' => 3,
                                        'xl' => 6,
                                        '2xl' => 9,
                                    ])
                                    ->schema([
                                        Select::make('account_type')
                                            ->options([
                                                'Student' => 'Student',
                                                'Staff' => 'Staff',
                                                'Teacher' => 'Teacher',
                                            ])
                                            ->required()
                                            ->native(false)
                                            ->columnSpanFull()
                                            ->label('Account Type'),
                                        TextInput::make('first_name')->required()->columnSpan(3),
                                        TextInput::make('middle_name')->required()->columnSpan(3),
                                        TextInput::make('last_name')->required()->columnSpan(3),
                                        Select::make('sex')
                                            ->options([
                                                'Male' => 'Male',
                                                'Female' => 'Female',
                                            ])->columnSpan(3),

                                        DatePicker::make('birth_date')->required()->label('Birth date')
                                            ->timezone('Asia/Manila')
                                            ->closeOnDateSelection()->required()
                                            ->columnSpan(3)
                                            ->native(false),
                                        TextInput::make('contact_number')
                                            ->columnSpan(3)
                                            ->maxLength(10)
                                            ->prefix('+63'),

                                            Textarea::make('address')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        FileUpload::make('image')
                                            ->disk('public')
                                            ->directory('accounts')
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorMode(2)
                                            ->required()
                                            ->columnSpanFull()
                                    ])->columnSpanFull(),



                            ])->modalWidth('6xl'),
                        DeleteAction::make(),
                    ]),
                ],
                // position: ActionsPosition::BeforeCells,
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])->label('Actions'),
            ])
            ->defaultGroup('account_type')
            ->groups([
                Group::make('account_type')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn (Account $record): string => $record->account_type ?  ucfirst($record->account_type) : '')
                    ->label('Account'),


            ])
         
            ;
    }

    public function render(): View
    {
        return view('livewire.accounts.list-accounts');
    }
}
