<?php

namespace App\Exports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class TotalStudentExport implements FromView
{
    public function view(): View
    {
        return view('exports.account-export', [
            'collection' =>Account::where('account_type', 'Student')->get()
        ]);
    }
}
