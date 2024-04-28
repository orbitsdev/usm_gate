<?php

namespace App\Models;

use App\Models\Card;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    public function card(){
        return $this->hasOne(Card::class);
    }


    public function getFullName(){
        return ($this->first_name ?? '') . ' ' . ($this->last_name ?? '');
    }
    public function getImage(){

        if(!empty($this->image)){
            return Storage::disk('public')->url($this->image);

        }else{
            // return asset('images/unknown.png');
            return "https://external-preview.redd.it/5kh5OreeLd85QsqYO1Xz_4XSLYwZntfjqou-8fyBFoE.png?auto=webp&s=dbdabd04c399ce9c761ff899f5d38656d1de87c2";
            return "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80";
        }
    }

    public function birthDay(){
        if(!empty($this->birth_date)){

            return Carbon::parse($this->birth_date)->format('F j, Y');
        }else{
            return '';
        }
    }
}
