<?php

namespace App\Http\Controllers\Api;

use App\Events\LogCreation;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    
    public function saveError(Request $request)
{
    try {
       
        DB::beginTransaction();

        $log = Log::create([
            'card_id' => $request->card_id,
            'source' => $request->source,
            'transaction' => $request->transaction,
            'error_type' => $request->error_type,
            'message' => $request->message,
        ]);

        LogCreation::dispatch($log);
        
      
        DB::commit();

        

        return response()->json(['data' => $log, 'success' => true, 'message' => 'Error Created']);

    } catch (\Exception $e) {
      
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error_type' => $request->error_type ?? null, // or $log->error_type
            'message' => $e->getMessage(),
        ], 500); // Use 500 for server error
    }
}

    
}
