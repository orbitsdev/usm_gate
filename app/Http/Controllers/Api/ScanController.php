<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    

    public function saveScan(Request $request)
    {
        try {
            if (!empty($request->card_id)) {
                $card = Card::where('id_number', $request->card_id)->first();
    
                if (!empty($card)) {
                    $transaction = Transaction::create([
                        'card_id' => $request->card_id,
                    ]);
    
                    // Return a success response
                    return response()->json([
                        'source' => 'usm',
                        'transaction' => $transaction,
                        'success' => true,
                        'message' => 'success',
                    ], 200);
                } else {
                    // Return a not found response
                    return response()->json([
                        'source' => 'usm',
                        'transaction' => null,
                        'success' => false,
                        'message' => 'Card Not Found',
                    ], 404);
                }
            } else {
                return response()->json([
                    'source' => 'usm',
                    'success' => false,
                    'message' => 'Invalid Request. Missing card_id',
                ], 400);
            }
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json([
                'source' => 'usm',
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    

}
