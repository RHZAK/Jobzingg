<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use HasFactory,SoftDeletes,Uuids;


    protected $fillable=['user_id','country_id','name','email','phone','address','image'];

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id');
    }

    public function country()
    {
        return $this->belongsTo('App\country', 'country_id');
    }


    public function ContactClient()
    {
        return $this->hasMany('App\ContactClient');
    }

    //export
    public static function getList(){

        $list= DB::table('countries')
        ->join('clients', 'clients.country_id', '=', 'countries.id')
        ->select('clients.name','clients.email','clients.phone','clients.address','countries.nationality')->where('clients.user_id',Auth::user()->id)
        ->get()->toArray();
        return $list;

    }
}
