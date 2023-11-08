<?php

namespace App\Exports;

use App\Models\Card;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class TotalInactiveCardExport implements FromView
{
    public function view(): View
    {
        return view('exports.cards-export', [
            'collection' => Card::where('status', 'Inactive')->get()
        ]);
    }
}
