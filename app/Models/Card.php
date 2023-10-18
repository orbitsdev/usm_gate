<?php

namespace App\Models;

use App\Models\Log;
use App\Models\Record;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    public function account(){
        return $this->belongsTo(Account::class);
    }
    public function records(){
        return $this->hasMany(Record::class);
    }


    public function logs(){
        return $this->hasMany(Log::class);
    }



public function transactions(){
    return $this->hasMany(Transaction::class);
}

}
