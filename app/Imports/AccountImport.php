<?php

namespace App\Imports;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountImport implements  ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try{
            
        
            DB::beginTransaction();
            $account = Account::where('id', $row['id'])->first();

            if($account){
                $account->update([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'middle_name' => $row['middle_name'],
                    'sex' => $row['sex'],
                    'birth_date' => $row['birth_date'],
                    'address' => $row['address'],
                    'contact_number' => $row['contact_number'],
                    'account_type' => $row['account_type'], 
                ]);
                $account->save();
            }else{

                $existingaccount = Account::where([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'middle_name' => $row['middle_name'],
                ])->first();
                if(empty($existingaccount)){
                    return new Account([
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'middle_name' => $row['middle_name'],
                        'sex' => $row['sex'],
                        'birth_date' => $row['birth_date'],
                        'address' => $row['address'],
                        'contact_number' => $row['contact_number'],
                        'account_type' => $row['account_type'], 
                     ]);
                }
               
            }
            DB::commit(); 

        }catch(QueryException $e){
            DB::rollBack(); 
        }
    }

}
