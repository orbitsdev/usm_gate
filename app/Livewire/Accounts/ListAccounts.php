<?php

namespace App\Livewire\Accounts;

use Filament\Tables;
use App\Models\Account;
use Filament\Forms\Get;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\AccountType;
use App\Exports\AccountExport;
use App\Imports\AccountImport;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
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
use Filament\Tables\Enums\FiltersLayout;
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

                    TextColumn::make('unique_id')->label('Account ID')
                    // ->formatStateUsing(fn($state)=>  strtoupper($state))
                    ->searchable(isIndividual: true, isGlobal: true)
                    ,
                    TextColumn::make('last_name')
                    ->label('Last name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                    ->searchable(isIndividual: true, isGlobal: true),
                    TextColumn::make('first_name')

                    ->label('First name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                    ->searchable(isIndividual: true, isGlobal: true),


                    TextColumn::make('middle_name')
                    ->label('Middle name')
                    ->formatStateUsing(fn($state)=> $state ? ucfirst($state) : $state)
                        ->searchable(),
                    TextColumn::make('sex')
                    ->label('Gender')
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
                        ->badge()
                        // ->color(fn (string $state): string => match ($state) {
                        //     'Student' => 'success',
                        //     'Staff' => 'primary',
                        //     'Guest' => 'gray',
                        //     default => 'info',
                        // })
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
                ->modalHeading("Create or Update Accounts.")
                ->modalDescription('Important Reminder: Please use the correct Excel file format when importing data. If you\'re updating details, ensure that the provided \'ID\' exists in the system; otherwise, it will create a new record. Your cooperation in adhering to this format and verifying the \'ID\' is crucial for a seamless data processing experience. Thank you for your attention to these guidelines')


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
                ->mutateFormDataUsing(function (array $data): array {
                //    unset($data['specify']);
             
                    return $data;
                })
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
                            
                            // Checkbox::make('specify')->label('Specify')->live() ->columnSpan(2),
                            Select::make('account_type')
                                ->options(AccountType::all()->pluck('name','name'))
                                ->required()
                                ->native(false)
                                ->columnSpanFull()
                                ->label('Account Type')
                                ->hidden(function(Get $get){
                                    if($get('specify')){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }),
                                TextInput::make('account_type')->required()->columnSpan(7)
                                ->label('Account Type')
                                ->hidden(function(Get $get){
                                    if($get('specify')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                })
                                ,
                                TextInput::make('first_name')->required()->columnSpan(3),
                            TextInput::make('middle_name')->required()->columnSpan(3),
                            TextInput::make('last_name')->required()->columnSpan(3),
                            Select::make('sex')
                            ->label('Gender')
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
                                // ->imageEditor()
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
                    ->options(AccountType::all()->pluck('name','name')),


                    Filter::make('account')

                    ->form([
                        Select::make('card-status')
                            ->options([
                                'has-card' => 'Has Card',
                                'no-card' => 'No Card',
                            ])
                            ->label('Card Status'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['card-status'] === 'has-card',
                                fn (Builder $query) => $query->has('card'),
                            )
                            ->when(
                                $data['card-status'] === 'no-card',
                                fn (Builder $query) => $query->doesntHave('card'),
                            );
                    }),

                    SelectFilter::make('sex')
                    ->label('Gender')
                        ->options([

                            'Male' => 'Male',
                            'Female' => 'Female',
                        ]),




                ],
                layout: FiltersLayout::AboveContent
                )
            ->actions(
                [
                    ActionGroup::make([

                        Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Details')
                        ->modalContent(function (Account $record) {
                            return view('livewire.account-details', ['record' => $record]);
                        })
                        ->modalHeading('Account Details')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        // ->slideOver()
                        ->modalWidth(MaxWidth::SevenExtraLarge),


                        EditAction::make()
                            ->mutateRecordDataUsing(function (Model $record, array $data): array {
                                // $data['account_id'] = auth()->id();
                                // unset($data['specify']);
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

                                        // Checkbox::make('specify')->label('Specify')->live() ->columnSpan(2),
                                        Select::make('account_type')
                                            ->options(AccountType::all()->pluck('name','name'))
                                            ->required()
                                            ->native(false)
                                            ->columnSpanFull()
                                            ->label('Account Type')
                                            ->hidden(function(Get $get){
                                                if($get('specify')){
                                                    return true;
                                                }else{
                                                    return false;
                                                }
                                            }),
                                            TextInput::make('account_type')->required()->columnSpan(7)
                                            ->label('Account Type')
                                            ->hidden(function(Get $get){
                                                if($get('specify')){
                                                    return false;
                                                }else{
                                                    return true;
                                                }
                                            })
                                            ,

                                        
                                        TextInput::make('first_name')->required()->columnSpan(3),
                                        TextInput::make('middle_name')->required()->columnSpan(3),
                                        TextInput::make('last_name')->required()->columnSpan(3),
                                        Select::make('sex')
                                        ->label('Gender')
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
                                            // ->imageEditor()
                                            // ->imageEditorMode(2)
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
                    ->label('Account')
                    ->collapsible()
                    ,




            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->latest())

            ;
    }

    public function render(): View
    {
        return view('livewire.accounts.list-accounts');
    }
}
