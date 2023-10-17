<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Account $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function edit(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
    }

    public function render(): View
    {
        return view('livewire.accounts.edit-account');
    }
}