<?php

namespace App\Exports;

use App\Models\Account;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class TotalAccountNoCardExport implements FromView
{
    public function view(): View
    {
        return view('exports.account-export', [
            'collection' => Account::whereDoesntHave('card')->latest()->get(),
        ]);
    }
}
