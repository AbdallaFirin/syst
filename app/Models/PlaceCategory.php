<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlaceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'policy_id', 'required_equipment'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
