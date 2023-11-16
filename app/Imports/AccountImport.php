<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountImport implements  ToModel, WithHeadingRow
{
    public function model(array $row)
    {


        // try{
            
        
        //     DB::beginTransaction();

        //     $account = Account::where('id', $row['id'])->first();

        //     $birth_date = $row['birth_date'];

        //     if (is_string($birth_date)) {
              
        //         // Convert string to Carbon instance with the format 'm/d/Y'
        //         $birth_date = Carbon::createFromFormat('m/d/Y', $birth_date)->format('Y-m-d');
        //     } elseif (is_numeric($birth_date)) {
             
        //         // Convert Excel serialized date to DateTime object
        //         $birth_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($birth_date);
        //     }
          
        //     if($account){
               
        //         $account->update([
        //             'first_name' => $row['first_name'],
        //             'last_name' => $row['last_name'],
        //             'middle_name' => $row['middle_name'],
        //             'sex' => $row['sex'],
        //             'birth_date' => $birth_date,
        //             'address' => $row['address'],
        //             'contact_number' => $row['contact_number'],
        //             'account_type' => $row['account_type'], 
        //         ]);
        //         $account->save();
        //     }else{

               
        //         $existingaccount = Account::where([
        //             'first_name' => $row['first_name'],
        //             'last_name' => $row['last_name'],
        //             'middle_name' => $row['middle_name'],
        //         ])->first();

        //         if(empty($existingaccount)){
        //             $new_account  = Account::create([
        //                 'first_name' => $row['first_name'],
        //                 'last_name' => $row['last_name'],
        //                 'middle_name' => $row['middle_name'],
        //                 'sex' => $row['sex'],
        //                 'birth_date' => $birth_date,
        //                 'address' => $row['address'],
        //                 'contact_number' => $row['contact_number'],
        //                 'account_type' => $row['account_type'], 
        //             ]);
                   
        //             return $new_account;
                   

        //         }else{
        //             $existingaccount->update([
        //                 'first_name' => $row['first_name'],
        //                 'last_name' => $row['last_name'],
        //                 'middle_name' => $row['middle_name'],
        //                 'sex' => $row['sex'],
        //                 'birth_date' => $birth_date,
        //                 'address' => $row['address'],
        //                 'contact_number' => $row['contact_number'],
        //                 'account_type' => $row['account_type'], 
        //             ]);
        //             $existingaccount->save();
        //         }
               
        //     }
        //     DB::commit();

        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        //     DB::rollback();
        // }



        $account = Account::where('id', $row['id'])->first();

            $birth_date = $row['birth_date'];

            if (is_string($birth_date)) {
              
                // Convert string to Carbon instance with the format 'm/d/Y'
                $birth_date = Carbon::createFromFormat('m/d/Y', $birth_date)->format('Y-m-d');
            } elseif (is_numeric($birth_date)) {
             
                // Convert Excel serialized date to DateTime object
                $birth_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($birth_date);
            }
          
            if($account){
               
                $account->update([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'middle_name' => $row['middle_name'],
                    'sex' => $row['sex'],
                    'birth_date' => $birth_date,
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
                    $new_account  = Account::create([
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'middle_name' => $row['middle_name'],
                        'sex' => $row['sex'],
                        'birth_date' => $birth_date,
                        'address' => $row['address'],
                        'contact_number' => $row['contact_number'],
                        'account_type' => $row['account_type'], 
                    ]);
                   
                    return $new_account;
                   

                }else{
                    $existingaccount->update([
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'middle_name' => $row['middle_name'],
                        'sex' => $row['sex'],
                        'birth_date' => $birth_date,
                        'address' => $row['address'],
                        'contact_number' => $row['contact_number'],
                        'account_type' => $row['account_type'], 
                    ]);
                    $existingaccount->save();
                }
               
            }
    }

}
