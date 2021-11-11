<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['user_id','candidate_id','title','type','date','time','online_url','importance'];

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate', 'candidate_id');
    }

}
