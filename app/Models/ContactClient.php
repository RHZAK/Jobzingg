<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactClient extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['client_id','first_name','last_name','poste','email','phone'];

    public function client()
    {
        return $this->belongsTo('App\client', 'client_id');
    }

    public function job()
    {
        return $this->hasMany('App\job');
    }
}
