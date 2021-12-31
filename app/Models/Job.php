<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory,SoftDeletes,Uuids;


    protected $fillable=['client_id','contact_clients_id','title','headcount','address','dead_line','tjm','description','contract_type','location'];


    public function contact_client()
    {
        return $this->belongsTo('App\contact_client', 'contact_clients_id');
    }

    public function client()
    {
        return $this->belongsTo('App\client', 'client_id');
    }
}
