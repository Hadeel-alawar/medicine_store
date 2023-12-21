<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Phar extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $hidden=['created_at','updated_at'];
    protected $fillable=["username","phone_number","password"];
    public function requests(){
        return $this->hasMany(Req::class,"phar_id");
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
