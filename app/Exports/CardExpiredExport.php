<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class CardExpiredExport implements FromView
{
    public function view(): View
    {
        return view('exports.cards-export', [
            'collection' => Card::where('status', 'Expired')->latest()->get()
        ]);
    }
}
