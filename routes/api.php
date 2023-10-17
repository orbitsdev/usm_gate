<?php

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::post('/check-card', function (Request $request) {
    try {
        // Start a database transaction
        DB::beginTransaction();

        $card = Card::where('status', 'Active')->where('id_number', $request->id_number)->first();

        if (!$card) {
            // Rollback the transaction if card is not found
            DB::rollBack();

            return response()->json(['error' => 'Card not found', 'success' => false], 404);
        }

        // Commit the transaction if everything is successful
        DB::commit();

        return response()->json(['data' => $card, 'success' => true]);
    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        // \Log::error('Exception: ' . $e->getMessage());

        // Rollback the transaction in case of an exception
        DB::rollBack();

        return response()->json(['error' => 'Internal server error', 'success' => false], 500);
    }
});

