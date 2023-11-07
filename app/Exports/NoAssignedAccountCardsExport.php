<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NoAssignedAccountCardsExport implements FromView
{
    public function view(): View
    {
        return view('exports.no-account-cards-export', [
            'collection' => Card::whereDoesntHave('account')->get()
        ]);
    }
}
