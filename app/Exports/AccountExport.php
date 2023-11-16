<?php

namespace App\Exports;

use App\Models\Account;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class AccountExport implements FromView
{
    public function view(): View
    {

        $data = Account::latest()->get();
        if(count($data) > 0){
            $collections = $data;
        } else{
            $collections = [
                (object) [
                   
                    'first_name' => 'user1examplefirstname',
                    'last_name' => 'user1examplelastname',
                    'middle_name' => 'user1middlefirstname',
                    'sex' => 'Male',
                    'birth_date' => '1990-01-01',
                    'address' => 'user1exampleaddress',
                    'contact_number' => '1234567890',
                    'account_type' => 'Student',
                ],
                (object) [
                    
                    'first_name' => 'user2examplefirstname',
                    'last_name' => 'user2examplelastname',
                    'middle_name' => 'user2middlefirstname',
                    'sex' => 'Female',
                    'birth_date' => '1991-02-02',
                    'address' => 'user2exampleaddress',
                    'contact_number' => '9876543210',
                    'account_type' => 'Teacher',
                ],
                (object) [
                  
                    'first_name' => 'user3examplefirstname',
                    'last_name' => 'user3examplelastname',
                    'middle_name' => 'user3middlefirstname',
                    'sex' => 'Male',
                    'birth_date' => '1992-03-03',
                    'address' => 'user3exampleaddress',
                    'contact_number' => '5555555555',
                    'account_type' => 'Staff',
                ],
            ];
        }
        return view('exports.account-export', [
            'collection' => $collections,
        ]);
    }
}
