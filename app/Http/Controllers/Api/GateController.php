<?php

namespace App\Http\Controllers\Api;

use App\Models\Day;
use App\Models\Card;
use App\Models\CardSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class GateController extends Controller
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
            return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'Not Found', 'message' => 'Cannot Procceed Card Not Found',  ], 404);
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

            return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'Card Not Active', 'message' => 'Cannot Procceed Card is ' . $card->status], 404);
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
            // return response()->json(['error' => 'Card is Validity Only in' , 'success' => false'source'=> 'USM-ADMIN'], 404);
        

            
            return response()->json([
                'source'=> 'USM-ADMIN', 
                'data'=> $card, 'success' => false , 'error_type'=> 'Card Expired', 'message' =>  'Cannot Procceed Card is expired. The validity of the card is valid only from ' . $cardValidFromStartOfDay->format('F j, Y') . ' until ' . $cardValidUntilEndOfDay->format('F j, Y') . ' based on the date set in the setting from ' . $cardSettingValidFromStartOfDay->format('F j, Y'), ], 404);

            // return response()->json([
            //     'error' => 'Card has expired. The validity of the card is valid only from ' . $cardValidFromStartOfDay->format('F j, Y') . ' until ' . $cardValidUntilEndOfDay->format('F j, Y') . ' based on the date set in the setting from ' . $cardSettingValidFromStartOfDay->format('F j, Y'),
            //     'success' => false
            // 'source'=> 'USM-ADMIN'], 404);
        }


        //  return response()->json(['data' => $card, 'success' => true, 'request'=> 'entry', 'day'=> $day,'card_setting_valid' => $isCardSettingValid, 'card_valid' => $isCardValid ]);



    }

    public function checkCardlatestRecord($card, $day, $request)
    {



        if ($request->scanned == 'entry') {

            return $this->cardProcessForEntry($card, $day, $request);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'entry']);
            
            
        } else if ($request->scanned == 'exit') {
            
            return $this->cardProcessForExit($card, $day, $request);

        } else {

            return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'No Scanned Parameter When Sending API', 'message' => 'Cannot Procceed  Cant Identify Whic Side of the door scanned missing parameter' ], 404);
            // return response()->json(['error' => 'scanned type no value', 'success' => false'source'=> 'USM-ADMIN'], 404);
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

                    return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => 'Success! Card Doesnt Have Entry Record']);
                    
                }else if($card_latest_record->entry == true  && $card_latest_record->exit == false){
                    
                    return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => false , 'error_type'=> 'Already Login', 'message' => 'Cannot proceed. Card cannot enter again until it has exited',], 404);
                    
                }else if($card_latest_record->entry == false  && $card_latest_record->exit == true){

                    return response()->json(['source'=> 'USM-ADMIN', 'data' => $card, 'success' => false, 'error_type' => 'Invalid Exit', 'message' => 'Cannot Procceed Invalid exit without entry',], 404);
                }
                
                else{
                    return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => 'Success! Card Ready To Login Again']);

                }
                


            } else {

                
                return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => 'Success! Card last Record is Not The Same Today']);
                // return response()->json(['data' => $card, 'success' => true, 'request' => 'last record is not the same today']);
            }

        } else {
            return response()->json(['source'=> 'USM-ADMIN', 'data'=> $card, 'success' => true , 'error_type'=> null, 'message' => 'Success! Card Doesnt Have Record ']);
            // return response()->json(['data' => $card, 'success' => true, 'request' => 'no last record means success']);
        }
    }

    public function cardProcessForExit($card, $day, $request)
    {

    
        $today = $day->created_at->startOfDay();
        $card_latest_record = $card->records()->latest()->first();
    
        if (!empty($card_latest_record)) {
            if ($card_latest_record->exit == false) {
    
                return response()->json(['source'=> 'USM-ADMIN','data' => $card, 'success' => true, 'error_type' => null, 'message' => 'Ready To Exit Because It nit exit yes']);
            } else {
                // Card has already exited on the same day
                return response()->json(['source'=> 'USM-ADMIN','data' => $card, 'success' => false, 'error_type' => 'Multiple Exit ', 'message' => 'Cannot Exit Over and Over Again. Enter first.', ], 404);
            }
        } else {
            // No records for the card yet, handle accordingly
            return response()->json(['source'=> 'USM-ADMIN','data' => $card, 'success' => true, 'error_type' => null, 'message' => 'No entry record found for the card']);
        }

       
    }

 

}
