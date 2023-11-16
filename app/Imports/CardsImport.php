<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CardsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {


            DB::beginTransaction();
            $data = Card::where('id', $row['id'])->first();
            $accountExist = Account::where('id', $row['account_id'])->first();

          

            $account = null;
            if ($accountExist) {
                $account = $accountExist->id;
            }
         
            // $validFrom = $row['valid_from'];
            // $validUntil = $row['valid_from'];
            $validFrom = $row['valid_from'];
            $validUntil = $row['valid_until'];
            
            // Check if the values are strings
            if (is_string($validFrom)) {
                // Convert string to Carbon instance with the format 'm/d/Y'
                $validFrom = Carbon::createFromFormat('m/d/Y', $validFrom)->format('Y-m-d');
            } elseif (is_numeric($validFrom)) {
                // Convert Excel serialized date to DateTime object
                $validFrom = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($validFrom);
            }
            
            // Repeat the same for $validUntil
            if (is_string($validUntil)) {
                $validUntil = Carbon::createFromFormat('m/d/Y', $validUntil)->format('Y-m-d');
            } elseif (is_numeric($validUntil)) {
                $validUntil = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($validUntil);
            }
          
            
            // Now $validFrom and $validUntil are either formatted strings or DateTime objects
            
            dd($data);
            if ($data) {
                // Update existing card
                $data->update([
                    'account_id' => $account,
                    'id_number' => $row['id_number'],
                    'valid_from' => $validFrom,
                    'valid_until' => $validUntil,
                    'status' => $row['status'],
                ]);
                $data->save();
            } else {
                // Check if a card with the same ID number already exists
                $existingData = Card::where('id_number', $row['id_number'])->first();
                
                if (!$existingData) {
                    
                    // If no existing card, create a new one
                    return new Card([
                        'account_id' => $account,
                        'id_number' => $row['id_number'],
                        'valid_from' => $validFrom,
                        'valid_until' => $validUntil,
                        'status' => $row['status'],
                    ]);
                } else {
                   
                  
                    // $existingData->update([
                    //     'account_id' => $account,
                    //     'valid_from' => $validFrom,
                    //     'valid_until' => $validUntil,
                    //     'status' => $row['status'],
                    // ]);
                    // $existingData->save();
                    // Handle the case where a card with the same ID number already exists
                    // You can log an error or perform any other necessary action
                }
            }
            DB::commit();
        } catch (QueryException $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
    }
}
