<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Candidate extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['user_id','country_id','name','phone','email','address','file','filedata','gender','birthday','year_first_experience'];


    public function country()
    {
        return $this->belongsTo('App\country', 'country_id');
    }

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id');
    }

        //export
        public static function getList(){

            $list= DB::table('countries')
            ->join('candidates', 'candidates.country_id', '=', 'countries.id')
            ->select('candidates.name','candidates.phone','candidates.email',
            'candidates.address','candidates.gender','candidates.birthday',
            'candidates.year_first_experience','countries.nationality')
            ->where('candidates.user_id',Auth::user()->id)
            ->get()->toArray();
            return $list;

        }

}
