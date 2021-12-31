<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassportClient extends Model
{
    use HasFactory;

    protected $connection = 'tenant'; // this tell passport to use the tenant DB to read clients
}
