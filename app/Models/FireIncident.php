<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FireIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'incident_cause_id',
        'incident_date',
        'human_loss',
        'injured_people',
        'financial_loss',
        'property_damage',
        'rescued_people',
        'rescued_assets',
        'additional_notes',
        'status'
    ];

    protected $casts = [
        'incident_date' => 'datetime',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function cause()
    {
        return $this->belongsTo(IncidentCause::class, 'incident_cause_id');
    }

    public function images()
    {
        return $this->hasMany(IncidentImage::class, 'fire_incident_id');
    }

    public function deathEvidence()
    {
        return $this->hasMany(IncidentImage::class, 'fire_incident_id')->where('category', 'death_evidence');
    }

    public function injuryEvidence()
    {
        return $this->hasMany(IncidentImage::class, 'fire_incident_id')->where('category', 'injury_evidence');
    }
}
