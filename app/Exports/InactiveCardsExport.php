<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InactiveCardsExport implements FromView
{
   

    public function view(): View
    {
        return view('exports.inactive-cards-export', [
            'collection' => Card::where('status', 'Inactive')->get()
        ]);
    }
}
