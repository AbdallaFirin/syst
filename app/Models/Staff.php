<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'shift', 'phone_number', 'is_active'];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
}
