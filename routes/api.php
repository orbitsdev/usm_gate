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

Route::get('/test', function(){

    $card = Card::first();

    return response()->json(['data'=>$card,'success'=> true]); 
});


