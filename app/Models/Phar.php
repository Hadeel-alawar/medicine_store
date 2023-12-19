<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phar extends Model
{
    use HasFactory;
    public function requests(){
        return $this->hasMany(Req::class,"phar_id");
    }
}
