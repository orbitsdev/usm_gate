<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id"=> $this->id,
            "day_id"=> $this->day_id,
            "card_id"=> $this->card_id,
            // "purpose_id"=> $this->purpose_id,
            // "door_id"=> $this->door_id,
            // "door_ip"=> $this->door_ip,
            "door_name"=> $this->door_name,
            "door_entered"=>$this->door_entered,
            "door_exit"=> $this->door_exit,
            "entry"=> $this->entry,
            "exit"=> $this->exit,
            "date"=>$this->dayDate(),
            "exact_day"=> $this->exactDay(),

            "in_complete_details"=> $this->inCompleteDetails(),
            "in_with_seconds"=> $this->inWithSeconds(),
            "in_without_seconds"=> $this->inWithoutSeconds(),

            "out_complete_details"=> $this->outCompleteDetails(),
            "out_with_seconds"=> $this->outWithSeconds(),
            "out_without_seconds"=> $this->outWithoutSeconds(),

            // "in_with_date"=> $this->created_at->format('F d, Y '),
            // "out_with_date"=> $this->updated_at->format('F d, Y '),
            // "in_with_date_and_time"=> $this->created_at->format('F d, Y h:i:s A'),
            // "out_with_date_and_time"=> $this->updated_at->format('F d, Y h:i:s A'),
        ];
    }
}
