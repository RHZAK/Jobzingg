<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable=['job_id','candidate_id','status'];

    public function job()
    {
        return $this->belongsTo('App\job', 'job_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate', 'candidate_id');
    }
}
