<?php

namespace App\Http\Controllers\Api;

use App\Events\Scanned;
use App\Models\Day;
use App\Models\Log;
use App\Models\Card;
use App\Models\Record;
use App\Models\CardSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class CheckCardApiController extends Controller
{
    public function checkCard(Request $request)
    {
        $card = Card::where('id_number', $request->id_number)->first();
        $transaction = Transaction::create([ 'card_id'=> $card->id ?? null, 'success' => !empty($card),  'source'=> $request->source,  'door_name'=> $request->door_name,  'scanned_type'=> $request->scanned_type, ]);

        if ($card) {
            $day = Day::latest()->first();

            if ($day) {
                return $this->checkDay($card, $day,  $request ,$transaction);
            } else {
                $day = Day::create();
                return $this->checkDay($card, $day,  $request ,$transaction);
            }

        } else {

            $this->updateTransaction('card-not-found', false, $transaction , 'Card Not Found');
            $log = Log::create([  'source'=> 'usm-admin',  'transaction'=> $request->request_type, 'error_type'=> 'not-found', 'message'=> '(checking) Cannot Procceed Card Not Found',]);
            return response()->json(['source'=> $log->source, 'transaction'=> $log->transaction, 'data'=> $card, 'success' => false , 'error_type'=> $log->error_type, 'message' => $log->message, ]);
        }
    }

    public function updateTransaction($error, $success , $transaction ,$message){
        $transaction->error_type = $error;
        $transaction->success = $success;
        $transaction->message = $message;
        $transaction->save();
    }
    // public function createTransaction($card ,$request){
    //     $new_transaction = Transaction::create([
    //         'card_id'=> $card->id ?? null,
    //         'source'=> $request->source,
    //         'door_name'=> $request->door_name,
    //         'scanned_type'=> $request->scanned_type,
    //     ]);
    // }

    public function checkDay($card, $day,  $request ,$transaction)

    {
        $today = now()->startOfDay();
        $latest_day_record = $day->created_at->startOfDay();

        if ($today->equalTo($latest_day_record)) {
            return $this->processCard($card, $day,  $request, $transaction);
        } else {
            $day = Day::create();
            return $this->processCard($card, $day,  $request, $transaction);
        }

    }

    public function processCard($card, $day, $request ,$transaction)
    {

        if(!empty($card->account)){
           return $this->checkCardIfActive($card, $day,  $request, $transaction);
        }else{

            $this->updateTransaction('card-doesnt-have-account-assigned', false, $transaction, 'No acccount was assigned to card');
            
            $log = Log::create([ 
                'card_id' => $card->id ?? null,
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'card-doesnt-have-account-assigned',
                'message'=> 'No acccount was assigned to card',
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ]);
        }

    }



    public function checkCardIfActive($card, $day,  $request, $transaction){
        if ($card->status == 'Active') {

            return $this->checkCardValidity($card, $day, $request ,$transaction);
        } else {
          

            $this->updateTransaction('card-not-active', false, $transaction, 'Cannot Procceed Card is '.$card->status);
            
            $log = Log::create([ 'card_id' => $card->id ?? null,
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'card-not-active',
                'message'=> '( checking ) Cannot Procceed Card is ' . $card->status,
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ]);

        }
    }
    public function checkCardValidity($card, $day,  $request, $transaction)
    {

        $card_setting = CardSettings::latest()->first();

   
        $cardSettingValidFrom = Carbon::parse($card_setting->valid_from);
        $cardSettingValidUntil = Carbon::parse($card_setting->valid_until);

         $cardValidFrom = Carbon::parse($card->valid_from);
        $cardValidUntil = Carbon::parse($card->valid_until);

         $cardSettingValidFromStartOfDay = $cardSettingValidFrom->startOfDay();
        $cardSettingValidUntilEndOfDay = $cardSettingValidUntil->endOfDay();

         $cardValidFromStartOfDay = $cardValidFrom->startOfDay();
        $cardValidUntilEndOfDay = $cardValidUntil->endOfDay();

        $isCardValid = now()->between($cardValidFromStartOfDay, $cardValidUntilEndOfDay);




        if ($isCardValid) {
            return $this->checkCardlatestRecord($card, $day,  $request, $transaction);
        } else {
           
            
            $date_validity_message = '( checking ) Cannot Procceed Card is expired. The validity of the card is valid only from ' . $cardValidFromStartOfDay->format('F j, Y') . ' until ' . $cardValidUntilEndOfDay->format('F j, Y') . ' based on the date set in the setting from ' . $cardSettingValidFromStartOfDay->format('F j, Y');

            $this->updateTransaction('card-is-expired', false, $transaction ,$date_validity_message);

            $log = Log::create([
                'card_id' => $card->id ?? null,
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'card-expired',
                'message'=> $date_validity_message,
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ]);



        }





    }

    public function checkCardlatestRecord($card, $day, $request ,$transaction)
    {



        if ($request->scanned_type == 'entry') {

            return $this->cardProcessForEntry($card, $day, $request, $transaction);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'entry']);
            
            
        } else if ($request->scanned_type == 'exit') {
            
            return $this->cardProcessForExit($card, $day, $request, $transaction);

        } else {
          

            $this->updateTransaction('card-api-missing-parameter-in-java', false, $transaction, 'Api missing parameter in java source code');


            $log = Log::create([
                'card_id' => $card->id ?? null,
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'api-missing-parameter',
                'message'=> '( checking ) Cannot Procceed  Cant Identify Whic Side of the door scanned missing parameter',
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ]);


            // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'No Scanned Parameter When Sending API', 'message' => '( checking ) Cannot Procceed  Cant Identify Whic Side of the door scanned missing parameter' ]);
            // return response()->json(['error' => 'scanned type no value', 'success' => false'transaction'=> $request->request_type,'source'=> 'USM-ADMIN']);
        }
    }

    public function cardProcessForEntry($card, $day, $request ,$transaction)
    {
        $today = $day->created_at->startOfDay();
        $card_latest_record = $card->records()->latest()->first();
        


        if (!empty($card_latest_record)) {
            $latest_day_record_date = $card_latest_record->updated_at->startOfDay();

            if ($today->equalTo($latest_day_record_date)) {

                
                if($card_latest_record->entry == false  && $card_latest_record->exit == false){

                    
                    if($request->request_type=='saving'){
                        $card_latest_record->entry = true;
                        $card_latest_record->door_entered = $request->door_name;
                        $card_latest_record->save();
                    }
                    
                    $this->updateTransaction(null, true, $transaction , 'Success! card doesnt have unfinished record ');
                    
                    return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Doesnt Have Entry Record']);
                    
                }else if($card_latest_record->entry == true  && $card_latest_record->exit == false){

                    $card_latest_record->update([
                        'door_entered' => $request->door_name,
                        'created_at' => $card_latest_record->freshTimestamp(),
                    ]);

                    $this->updateTransaction('multiple-entry-attempt', true, $transaction, 'Access Granted! You are attempting to enter multiple times. Just a friendly reminder to use it responsibly.');

                    $log = Log::create([
                        'card_id' => $card->id ?? null,
                        'source'=> 'usm-admin',
                        'transaction'=> $request->request_type,
                        'error_type'=> 'multiple-enter-attempt',
                        'message'=> '( checking ) You can proceed but you must exit f Card cannot enter again until it has exited',
                    ]);

                    
        
                    return response()->json([
                        
                        'source'=> $log->source,
                        'transaction'=> $log->transaction,
                        'data'=> $card, 
                        'success' => true , 
                        'error_type'=> $log->error_type,
                        'message' => $log->message, 
                     ]);
                    
                 
                    
                }else if($card_latest_record->entry == false  && $card_latest_record->exit == true){

                    $this->updateTransaction('invalid-exit-no-entry-found', false, $transaction, 'Attempted to exit, but the card doesn\'t have an exit record.');
                    $log = Log::create([
                        'card_id' => $card->id ?? null,
                        'source'=> 'usm-admin',
                        'transaction'=> $request->request_type,
                        'error_type'=> 'invalid-exit',
                        'message'=> '( checking ) Cannot Procceed Invalid exit without entry',
                    ]);
        
                    return response()->json([
                        
                        'source'=> $log->source,
                        'transaction'=> $log->transaction,
                        'data'=> $card, 
                        'success' => false , 
                        'error_type'=> $log->error_type,
                        'message' => $log->message, 
                     ]);
                    

                    // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data' => $card, 'success' => false, 'error_type' => 'Invalid Exit', 'message' => '( checking ) Cannot Procceed Invalid exit without entry',]);
                }
                
                else{

                    $this->updateTransaction(null, true, $transaction, 'Success card ready for another transaction');
                    if($request->request_type=='saving'){
                        $new_record = Record::create([ 
                            'day_id'=> $day->id,
                            'card_id'=> $card->id,
                            'door_entered' => $request->door_name,
                            'door_name'=> $request->door_name,
                            'entry'=> true,
                        ]);
                    }
                    return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Ready To Login Again']);

                }
                


            } else {
                
                $this->updateTransaction(null, true, $transaction ,'Success card doesnt have latest record today');
                if($request->request_type=='saving'){
                    $new_record = Record::create([ 
                        'day_id'=> $day->id,
                        'card_id'=> $card->id,
                        'door_name'=> $request->door_name,
                        'door_entered' => $request->door_name,
                        'entry'=> true,
                    ]);
                }
                
                return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card last Record is Not The Same Today']);
                // return response()->json(['data' => $card, 'success' => true, 'request' => 'last record is not the same today']);
            }

        } else {

            $this->updateTransaction(null, true, $transaction, 'Success, the card doesn\'t have any record.');
            if($request->request_type=='saving'){
                $new_record = Record::create([ 
                    'day_id'=> $day->id,
                    'card_id'=> $card->id,
                    'door_name'=> $request->door_name,
                    'door_entered' => $request->door_name,
                    'entry'=> true,
                ]);
            }
            return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Doesnt Have Record ']);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'no last record means success']);
        }
    }

    public function cardProcessForExit($card, $day, $request ,$transaction)
    {

        $today = $day->created_at->startOfDay();
        $card_latest_record = $card->records()->latest()->first();
    
        if (!empty($card_latest_record)) {

            if ($card_latest_record->exit == false) {
                if($request->request_type=='saving'){
                    $card_latest_record->exit = true;
                    $card_latest_record->door_exit = $request->door_name;
                    $card_latest_record->save();
                }

                $this->updateTransaction(null, true, $transaction, 'Success, the card has no exit record yet');

                return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => true, 'error_type' => null, 'message' => '( checking ) Ready To Exit Because It nit exit yes']);
            } else {


                
                $log = Log::create([
                    'card_id' => $card->id ?? null,
                    'source'=> 'usm-admin',
                    'transaction'=> $request->request_type,
                    'error_type'=> 'multiple-exit-attempt',
                    'message'=> '( checking ) Cannot Exit Over and Over Again. Enter first.',
                ]);
                
                $card_latest_record->update([
                    'door_exit' => $request->door_name,
                ]);
                $card_latest_record->touch();
                $this->updateTransaction('multiple-exit-attempt', true, $transaction, 'Multiple exit attempts. Please exit now. If you are trying to enter, please proceed to the entry');
                return response()->json([
                    
                    'source'=> $log->source,
                    'transaction'=> $log->transaction,
                    'data'=> $card, 
                    'success' => true , 
                    'error_type'=> $log->error_type,
                    'message' => $log->message, 
                 ]);

                // Card has already exited on the same day
                // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => false, 'error_type' => 'Multiple Exit ', 'message' => '( checking ) Cannot Exit Over and Over Again. Enter first.', ]);
            }
        } else {

            $log = Log::create([
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'no-entry-record',
                'message'=> '( checking ) No entry record found for the card',
            ]);
            
            $this->updateTransaction('no-entry-record', false, $transaction, 'The card doesn\'t have an entry record.');
            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ]);


            // No records for the card yet, handle accordingly
            // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => false, 'error_type' => null, 'message' => '( checking ) No entry record found for the card']);
       
        }

}


}
