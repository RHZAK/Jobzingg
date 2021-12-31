<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory,Uuids,SoftDeletes;

    protected $fillable=['position_id','type','original_name','file'];

    public function position()
    {
        return $this->belongsTo('App\position', 'position_id');
    }
}
