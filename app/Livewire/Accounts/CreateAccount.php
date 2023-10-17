<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(191),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(191),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(191),
                Forms\Components\TextInput::make('sex')
                    ->maxLength(191),
                Forms\Components\DatePicker::make('birth_date'),
                Forms\Components\Textarea::make('address')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_number')
                    ->maxLength(191),
                Forms\Components\Textarea::make('image')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ])
            ->statePath('data')
            ->model(Account::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Account::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.accounts.create-account');
    }
}