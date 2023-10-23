<?php

namespace App\Imports;

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
        try{
            
        
            DB::beginTransaction();
            $data = Card::where('id', $row['id'])->first();
            $accountExist = Account::where('id', $row['account_id'])->first();

        
        
            $account= null;
            if($accountExist){
                $account = $accountExist->id;
            }
    
            if($data){
                $data->update([
                    'account_id' =>$account,
                    'id_number' =>$row['id_number'],
                    'valid_from' =>$row['valid_from'], 
                    'valid_until' => $row['valid_until'], 
                    'status' => $row['status'],
                ]);
                $data->save();
            }else{

                $existingdata = Card::where([
                    'id_number' =>$row['id_number'],
                    'valid_from' =>$row['valid_from'], 
                    'valid_until' => $row['valid_until'], 
                ])->first();
                if(empty($existingdata)){
                    return new Card([
                        'account_id' =>$account,
                        'id_number' =>$row['id_number'],
                        'valid_from' =>$row['valid_from'], 
                        'valid_until' => $row['valid_until'], 
                        'status' => $row['status'],
                     ]);
                }
               
            }
            DB::commit(); 

        }catch(QueryException $e){
            DB::rollBack(); 
        }
    }

}
