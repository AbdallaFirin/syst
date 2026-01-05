<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'fire_incident_id',
        'image_path',
        'caption',
    ];

    public function incident()
    {
        return $this->belongsTo(FireIncident::class, 'fire_incident_id');
    }
}
