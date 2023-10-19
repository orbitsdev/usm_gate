<?php

namespace App\Http\Controllers\Api;

use App\Models\Day;
use App\Models\Log;
use App\Models\Card;
use App\Models\Record;
use App\Models\CardSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class CheckCardApiController extends Controller
{
    public function checkCard(Request $request)
    {
        $card = Card::where('id_number', $request->id_number)->first();

        if ($card) {
            $day = Day::latest()->first();

            if ($day) {
                return $this->checkDay($card, $day,  $request);
            } else {
                $day = Day::create();
                return $this->checkDay($card, $day,  $request);
            }
        } else {

            $log = Log::create([

                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'not-found',
                'message'=> '(checking) Cannot Procceed Card Not Found',
            ]);

            return response()->json([
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message,  ], 404);
        }
    }

    public function checkDay($card, $day,  $request)

    {
        $today = now()->startOfDay();
        $latest_day_record = $day->created_at->startOfDay();

        if ($today->equalTo($latest_day_record)) {
            return $this->processCard($card, $day,  $request);
        } else {
            $day = Day::create();
            return $this->processCard($card, $day,  $request);
        }
    }

    public function processCard($card, $day, $request)
    {

        if ($card->status == 'Active') {

            return $this->checkCardValidity($card, $day, $request);
        } else {


            $log = Log::create([
                'card_id' => $card->id,
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
             ], 404);

        }
    }


    public function checkCardValidity($card, $day,  $request)
    {

        $card_setting = CardSettings::latest()->first();

        // Assuming $mycard is an instance of Card

        // Convert valid_from and valid_until to Carbon instances for CardSettings
        $cardSettingValidFrom = Carbon::parse($card_setting->valid_from);
        $cardSettingValidUntil = Carbon::parse($card_setting->valid_until);

        // Convert valid_from and valid_until to Carbon instances for Card
        $cardValidFrom = Carbon::parse($card->valid_from);
        $cardValidUntil = Carbon::parse($card->valid_until);

        // Convert valid_from and valid_until to start and end of the day for CardSettings
        $cardSettingValidFromStartOfDay = $cardSettingValidFrom->startOfDay();
        $cardSettingValidUntilEndOfDay = $cardSettingValidUntil->endOfDay();

        // Convert valid_from and valid_until to start and end of the day for Card
        $cardValidFromStartOfDay = $cardValidFrom->startOfDay();
        $cardValidUntilEndOfDay = $cardValidUntil->endOfDay();

        // // Check if the current date is within the validity range for CardSettings
        // $isCardSettingValid = now()->between($cardSettingValidFromStartOfDay, $cardSettingValidUntilEndOfDay);

        // Check if the current date is within the validity range for Card
        $isCardValid = now()->between($cardValidFromStartOfDay, $cardValidUntilEndOfDay);


        //USE THIS IF YOUY WAAN ONLY IN THE RANGE
        // $isCardValid = now()->isAfter($cardValidFromStartOfDay) && now()->isBefore($cardValidUntilEndOfDay);

        if ($isCardValid) {
            return $this->checkCardlatestRecord($card, $day,  $request);
        } else {


            $log = Log::create([
                'card_id' => $card->id,
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'card-expired',
                'message'=> '( checking ) Cannot Procceed Card is expired. The validity of the card is valid only from ' . $cardValidFromStartOfDay->format('F j, Y') . ' until ' . $cardValidUntilEndOfDay->format('F j, Y') . ' based on the date set in the setting from ' . $cardSettingValidFromStartOfDay->format('F j, Y'),
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ], 404);



        }





    }

    public function checkCardlatestRecord($card, $day, $request)
    {



        if ($request->scanned == 'entry') {

            return $this->cardProcessForEntry($card, $day, $request);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'entry']);
            
            
        } else if ($request->scanned == 'exit') {
            
            return $this->cardProcessForExit($card, $day, $request);

        } else {

            $log = Log::create([
                'card_id' => $card->id,
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
             ], 404);


            // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'No Scanned Parameter When Sending API', 'message' => '( checking ) Cannot Procceed  Cant Identify Whic Side of the door scanned missing parameter' ], 404);
            // return response()->json(['error' => 'scanned type no value', 'success' => false'transaction'=> $request->request_type,'source'=> 'USM-ADMIN'], 404);
        }
    }

    public function cardProcessForEntry($card, $day, $request)
    {
        $today = $day->created_at->startOfDay();
        $card_latest_record = $card->records()->latest()->first();
        


        if (!empty($card_latest_record)) {
            $latest_day_record_date = $card_latest_record->updated_at->startOfDay();

            if ($today->equalTo($latest_day_record_date)) {

                
                if($card_latest_record->entry == false  && $card_latest_record->exit == false){


                    
                    if($request->request_type=='saving'){
                        $card_latest_record->entry = true;
                        $card_latest_record->save();
                    }


                    return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Doesnt Have Entry Record']);
                    
                }else if($card_latest_record->entry == true  && $card_latest_record->exit == false){

                    $log = Log::create([
                        'card_id' => $card->id,
                        'source'=> 'usm-admin',
                        'transaction'=> $request->request_type,
                        'error_type'=> 'multiple-enter-attempt',
                        'message'=> '( checking ) Cannot proceed. Card cannot enter again until it has exited',
                    ]);
        
                    return response()->json([
                        
                        'source'=> $log->source,
                        'transaction'=> $log->transaction,
                        'data'=> $card, 
                        'success' => false , 
                        'error_type'=> $log->error_type,
                        'message' => $log->message, 
                     ], 404);
                    
                 
                    
                }else if($card_latest_record->entry == false  && $card_latest_record->exit == true){

                    $log = Log::create([
                        'card_id' => $card->id,
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
                     ], 404);
                    

                    // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data' => $card, 'success' => false, 'error_type' => 'Invalid Exit', 'message' => '( checking ) Cannot Procceed Invalid exit without entry',], 404);
                }
                
                else{

                    if($request->request_type=='saving'){
                        $new_record = Record::create([ 
                            'day_id'=> $day->id,
                            'card_id'=> $card->id,
                            'door_ip'=> '23023021',
                            'entry'=> true,
                        ]);
                    }
                    return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Ready To Login Again']);

                }
                


            } else {
                
                if($request->request_type=='saving'){
                    $new_record = Record::create([ 
                        'day_id'=> $day->id,
                        'card_id'=> $card->id,
                        'door_ip'=> '23023021',
                        'entry'=> true,
                    ]);
                }
                
                return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card last Record is Not The Same Today']);
                // return response()->json(['data' => $card, 'success' => true, 'request' => 'last record is not the same today']);
            }

        } else {
            if($request->request_type=='saving'){
                $new_record = Record::create([ 
                    'day_id'=> $day->id,
                    'card_id'=> $card->id,
                    'door_ip'=> '23023021',
                    'entry'=> true,
                ]);
            }
            return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => '( checking ) Success! Card Doesnt Have Record ']);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'no last record means success']);
        }
    }

    public function cardProcessForExit($card, $day, $request)
    {

        $today = $day->created_at->startOfDay();
        $card_latest_record = $card->records()->latest()->first();
    
        if (!empty($card_latest_record)) {
            if ($card_latest_record->exit == false) {
                if($request->request_type=='saving'){
                    $card_latest_record->exit = true;
                    $card_latest_record->save();
                }
                return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => true, 'error_type' => null, 'message' => '( checking ) Ready To Exit Because It nit exit yes']);
            } else {


                $log = Log::create([
                    'card_id' => $card->id,
                    'source'=> 'usm-admin',
                    'transaction'=> $request->request_type,
                    'error_type'=> 'multiple-exit-attempt',
                    'message'=> '( checking ) Cannot Exit Over and Over Again. Enter first.',
                ]);
    
                return response()->json([
                    
                    'source'=> $log->source,
                    'transaction'=> $log->transaction,
                    'data'=> $card, 
                    'success' => false , 
                    'error_type'=> $log->error_type,
                    'message' => $log->message, 
                 ], 404);

                // Card has already exited on the same day
                // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => false, 'error_type' => 'Multiple Exit ', 'message' => '( checking ) Cannot Exit Over and Over Again. Enter first.', ], 404);
            }
        } else {


            $log = Log::create([
                'source'=> 'usm-admin',
                'transaction'=> $request->request_type,
                'error_type'=> 'no-entry-record',
                'message'=> '( checking ) No entry record found for the card',
            ]);

            return response()->json([
                
                'source'=> $log->source,
                'transaction'=> $log->transaction,
                'data'=> $card, 
                'success' => false , 
                'error_type'=> $log->error_type,
                'message' => $log->message, 
             ], 404);


            // No records for the card yet, handle accordingly
            // return response()->json(['transaction'=> $request->request_type,'source'=> 'USM-ADMIN','data' => $card, 'success' => false, 'error_type' => null, 'message' => '( checking ) No entry record found for the card']);
       
        }

}


}
