<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     protected $records;

     public function __construct($resource, $records = null)
     {
         parent::__construct($resource);
         $this->records = $records;
     }
    public function toArray(Request $request): array
    {
        return [
            'card'=>[
                'id' => $this->id,
                'account_id' => $this->account_id,
                'rf_id' => $this->id_number,
                'school_id' => $this->qr_number,
                'valid_until' => $this->valid_until,
                'status' => $this->status,
                'created_at' => $this->created_at->format('F d, Y h:i:s A'),
                'updated_at' => $this->updated_at->format('F d, Y h:i:s A'),
            ],
            'account'=> new AccountResource($this->account),
            'records'=> $this->records,
        ];
    }
}
