<?php

namespace App\Models;

use App\Models\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    public function card(){
        return $this->belongsTo(Card::class);
    }

    public function recordAt(){

        return $this->created_at->format('M d, Y  h:i:s A');

       
    }
   
    public function updateAt(){
        return $this->updated_at->format('M d, Y  h:i:s A');
       
    }
}
