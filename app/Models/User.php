<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Stancl\Tenancy\Contracts\Syncable;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;
use Illuminate\Auth\Authenticatable;


// use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

class User extends Model implements Syncable
{
    use SoftDeletes, Uuids, ResourceSyncing , HasApiTokens,Authenticatable;

    protected $guarded = [];
    public $timestamps = false;

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];


    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getCentralModelName(): string
    {
        return CentralUser::class;
    }

    public function getSyncedAttributeNames(): array
    {
        return ['first_name', 'last_name', 'email', 'password'];
    }
}
