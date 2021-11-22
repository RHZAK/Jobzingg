<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['candidate_id','school','degree','industry','start_date','score','address','description'];


    public function candidate()
    {
        return $this->belongsTo('App\candidate', 'candidate_id');
    }
}
