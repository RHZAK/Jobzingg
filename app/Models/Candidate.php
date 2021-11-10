<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['country_ID','name','phone','email','address','description','gender','birthday','year_first_experience'];


    public function country()
    {
        return $this->belongsTo('App\country', 'country_ID');
    }
}
