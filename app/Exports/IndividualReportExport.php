<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class IndividualReportExport implements FromView
{   


    public $records;

    public function __construct($records){
        $this->records = $records;
    }
    public function view(): View
    {   


        return view('exports.individual-report-export', [
            'collections' => $this->records,
        ]);
    }
}
