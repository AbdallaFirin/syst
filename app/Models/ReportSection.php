<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'introduction',
        'conclusion',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
