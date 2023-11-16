<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class TotalNoAccountCardExport implements FromView
{
    public function view(): View
    {
        return view('exports.cards-export', [
            'collection' => Card::whereDoesntHave('account')->latest()->get()
        ]);
    }
}
