<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_name',
        'maintenance_type',
        'performed_at',
        'cost',
        'details',
        'performed_by',
    ];
}
