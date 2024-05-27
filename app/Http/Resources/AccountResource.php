<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'school_id' => $this->unique_id,
            'first_name' => $this->email,
            'last_name' => $this->last_name,
            'middle_name'=> $this->middle_name,
            'full_name'=> $this->getFullName(),
            'sex'=> $this->sex,
            'birth_date'=> $this->birthDay(),
            'address'=> $this->address,
            'contact_number'=> $this->contact_number,
            'image'=> $this->getImage(),
            'account_type'=> $this->account_type,
            'created_at' => $this->created_at->format('F d, Y h:i:s A'),
            'updated_at' => $this->updated_at->format('F d, Y h:i:s A'),
        ];
    }
}
