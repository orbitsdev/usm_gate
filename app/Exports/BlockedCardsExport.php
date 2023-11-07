<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class BlockedCardsExport implements FromView
{
   

    public function view(): View
    {
        return view('exports.blocked-cards-export', [
            'collection' => Card::where('status', 'Blocked')->get()
        ]);
    }
}
