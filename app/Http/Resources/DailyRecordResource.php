<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id'=> $this->id,
            'Account' => $this->when(optional($this->card)->account, function () {
                return optional($this->card->account)->getFullName() ?? 'No Account Found';
            }, 'No Account Found'),


            'Card ID' => optional($this->card)->id_number ?? 'No Card Found',
            'QR Number' => optional($this->card)->qr_number ?? 'No Qr Found',


            'Account Type' => optional(optional($this->card)->account)->account_type ?? 'No Account Found',


            'Time In' => $this->entry ? optional($this->created_at)->format('l-F d, Y h:i:s A') : 'None',


            'Time Out' => ($this->entry && $this->exit) ? optional($this->updated_at)->format('l-F d, Y h:i:s A') : '-- No Exit --',

        ];
    }
}
