<?php

namespace App\Exports;

use App\Models\Card;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class CardsExport implements FromView
{
    public function view(): View
    {   

        $data = Card::latest()->get();
        if(count($data)>0){
            $collections = $data;
        }else{
            $collections = [
                (object) [
                    
                    'id_number' => 123456789,
                    'qr_number' => '123-4567-89',
                    'valid_from' => now(),
                    'valid_until' => now()->addYears(1),
                    'status' => 'Active',
                ],
                (object) [
                   
                    'id_number' => 987654321,
                    'qr_number' => '98-7654-321',
                    'valid_from' => now(),
                    'valid_until' => now()->addYears(1),
                    'status' => 'Active',
                ],
                (object) [
                    
                    'id_number' => 555555555,
                    'qr_number' => '555-555-555',
                    'valid_from' => now(),
                    'valid_until' => now()->addYears(1),
                    'status' => 'Inactive',
                ],
            ];
        }
        return view('exports.cards-export', [
            'collection' =>$collections
        ]);
    }
}

