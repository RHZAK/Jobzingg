<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['candidate_id','skill_id','level'];

    public function candidate()
    {
        return $this->belongsTo('App\candidate', 'candidate_id');
    }
    public function skill()
    {
        return $this->belongsTo('App\skill', 'skill_id');
    }
}
