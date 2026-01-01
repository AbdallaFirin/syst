<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'place_category_id',
        'location',
        'contact_person',
        'phone_number_1',
        'phone_number_2',
        'phone_number_3'
    ];

    public function category()
    {
        return $this->belongsTo(PlaceCategory::class, 'place_category_id');
    }

    public function fireIncidents()
    {
        return $this->hasMany(FireIncident::class);
    }
}
