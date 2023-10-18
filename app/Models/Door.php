<?php

namespace App\Models;

use App\Models\Record;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Door extends Model
{
    use HasFactory;


    public function records(){
        return $this->hasMany(Record::class);
    }
}
