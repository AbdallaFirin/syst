<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chemical extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'chemical_type', 'description', 'manufacture_date', 'expiry_date', 'quantity', 'unit'];

    public function placeCategories()
    {
        return $this->belongsToMany(PlaceCategory::class);
    }
}
