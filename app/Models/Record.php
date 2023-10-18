<?php

namespace App\Models;

use App\Models\Day;
use App\Models\Card;
use App\Models\Door;
use App\Models\Purpose;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Record extends Model
{
    use HasFactory;

    public function day(){
        return $this->belongsTo(Day::class);
    }
    public function purpose(){
        return $this->belongsTo(Purpose::class);
    }

    public function door(){
        return $this->belongsTo(Door::class);
    }
    
    public function card(){
        return $this->belongsTo(Card::class);
    }
    
}
