<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes,Uuids;


    protected $fillable=['user_ID','country_ID','name','email','phone','address','image'];

    public function user()
    {
        return $this->belongsTo('App\user', 'user_ID');
    }

    public function country()
    {
        return $this->belongsTo('App\country', 'country_ID');
    }


    public function ContactClient()
    {
        return $this->hasMany('App\ContactClient');
    }
}
