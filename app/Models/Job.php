<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory,SoftDeletes,Uuids;


    protected $fillable=['client_ID','contact_clients_ID','title','headcount','address','dead_line','tgm','description','contract_type','location'];


    public function contact_client()
    {
        return $this->belongsTo('App\contact_client', 'contact_clients_ID');
    }

    public function client()
    {
        return $this->belongsTo('App\client', 'client_ID');
    }
}
