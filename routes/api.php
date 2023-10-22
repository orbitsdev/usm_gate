<?php

use App\Models\Day;
use App\Models\Card;
use App\Models\Record;
use App\Events\Scanned;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GateController;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Api\ErrorController;
use App\Http\Controllers\Api\CardSaveRecontroller;
use App\Http\Controllers\Api\CheckCardApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/check-card', [CheckCardApiController::class, 'checkCard'])->name('check-card');
// Route::post('/save-record', [CardSaveRecontroller::class, 'saveRecord'])->name('save-record');
Route::post('/save-error', [ErrorController::class, 'saveError'])->name('save-error');
Route::post('/save-scan', [ScanController::class, 'saveScan'])->name('save-scan');

Route::post('/test', function(Request $request){

    $card = Card::where('id_number', $request->id_number)->first();

    $new_transaction = Transaction::create([
        'card_id'=> $card->id ?? null,
        'source'=> $request->source,
        'door_name'=> $request->door_name,
        'scanned_type'=> $request->scanned_type,
    ]);
    // Scanned::dispatch($card);
    
    return response()->json(['data'=>$new_transaction,'success'=> true]); 
});



// Route::post('/check-card', function (Request $request) {


//         $card = Card::where('status', 'Active')->where('id_number', $request->id_number)->first();
      





//         if($card){  
            
//             $day = Day::latest()->first();

//             if($day){

             
//             }else{
                
//                 $day  = Day::create();


                
//             }

//          return response()->json(['data' => $card, 'success' => true, 'request'=> 'entry', 'day'=> $day]);


//             // $now_day = now()->startOfDay();
//             // $active_record = $day->created_at->startOfDay();


//             // $latest_record = Record::where('card_id', $card->id)->first();
            
//             // if($request->scanned == 'entry'){


//             //     // if($card->){

//             //     // }
//             //     // return response()->json(['data' => $card, 'success' => true, 'request'=> 'entry']);
//             // }
//             // if($request->scanned == 'exit'){
//             //     return response()->json(['data' => $card, 'success' => true, 'request'=> 'exit']);
                
//             // }
            

//             return response()->json(['error' => 'Undifined Scanned', 'success' => false], 404);



//         }else{
//             return response()->json(['error' => 'Card not found', 'success' => false], 404);
//         }


//     // try {
//     //     // Start a database transaction
//     //     DB::beginTransaction();

//     //     $card = Card::where('status', 'Active')->where('id_number', $request->id_number)->first();

//     //     if (!$card) {
//     //         // Rollback the transaction if card is not found
//     //         DB::rollBack();

//     //         return response()->json(['error' => 'Card not found', 'success' => false], 404);
//     //     }

//     //     // Commit the transaction if everything is successful
//     //     DB::commit();

//     //     return response()->json(['data' => $card, 'success' => true]);
//     // } catch (\Exception $e) {
//     //     // Log the exception for debugging purposes
//     //     // \Log::error('Exception: ' . $e->getMessage());

//     //     // Rollback the transaction in case of an exception
//     //     DB::rollBack();

//     //     return response()->json(['error' => 'Internal server error', 'success' => false], 500);
//     // }
// });

