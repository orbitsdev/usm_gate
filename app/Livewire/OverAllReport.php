<?php

namespace App\Livewire;

use App\Models\Record;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class OverAllReport extends Component implements HasForms
{

    use InteractsWithForms;
    
    public ?array $data = [];

    public $records = [];
    public $day;


    

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('author_id')
    ->label('Author')
    ->options(Record::all()->pluck('name', 'id'))
    ->searchable()
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }
    public function render()
    {
        return view('livewire.over-all-report');
    }

    
}
