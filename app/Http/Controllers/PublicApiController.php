<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\ResponseHelper;
use App\Http\Resources\CardResource;
use App\Http\Resources\RecordResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PublicApiController extends Controller
{

    public function getCardDetails(Request $request)
    {



        try {
            $card = Card::where('id_number', $request->rf_id)->orWhere('qr_number', $request->school_id)->firstOrFail();

            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $end_date_parsed = Carbon::parse($end_date)->format('Y-m-d');
            $start_date_parsed = Carbon::parse($start_date)->format('Y-m-d');



            $records = Record::where('card_id', $card->id)
                ->when(!empty($start_date) && !empty($end_date), function ($query) use ($start_date_parsed, $end_date_parsed) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($start_date_parsed)->startOfDay(),
                        Carbon::parse($end_date_parsed)->endOfDay(),
                    ]);
                })
                ->when(!empty($start_date) && empty($end_date), function ($query) use ($start_date_parsed) {

                    $firstDayOfMonth = Carbon::parse($start_date_parsed)->startOfMonth()->format('Y-m-d');
                    $query->whereBetween('created_at', [
                        Carbon::parse($firstDayOfMonth)->startOfDay(),
                        Carbon::parse($start_date_parsed)->endOfDay(),
                    ]);
                })
                ->when(empty($start_date) && !empty($end_date), function ($query) use ($end_date_parsed) {
                    $firstDayOfMonth = Carbon::parse($end_date_parsed)->startOfMonth()->format('Y-m-d');
                    $query->whereBetween('created_at', [
                        Carbon::parse($firstDayOfMonth)->startOfDay(),
                        Carbon::parse($end_date_parsed)->endOfDay(),
                    ]);
                })
                ->get();






            if ($card) {
                return ResponseHelper::success(new CardResource($card, RecordResource::collection($records)));
            } else {
                return ResponseHelper::error('Card not found', 404);
            }
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Card not found', 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            return ResponseHelper::error('An error occurred while processing the request', 500);
        }
    }
}
