<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlaceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'policy_id', 'required_equipment', 'icon'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function chemicals()
    {
        return $this->belongsToMany(Chemical::class);
    }
}
