<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = ["phar_id"];
    public function medications()
    {
        return $this->belongsToMany(Medication::class, "med_fav_pivot", "fav_id","medication_id");
    }
    public function pharmacists()
    {
        return $this->hasMany(Phar::class, "phar_fav_pivot");
    }
}
