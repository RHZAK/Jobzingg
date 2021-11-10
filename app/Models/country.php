<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    protected $fillable=['country_id','counrty','nationality'];


   public function client()
   {
       return $this->hasMany('App\client');
   }

   public function candidate()
   {
       return $this->hasMany('App\candidate');
   }


}
