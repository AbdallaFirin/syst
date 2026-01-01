<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_type', 'plate_number', 'staff_id'];

    public function driver()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
