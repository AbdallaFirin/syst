<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_title',
        'original_title',
        'period_start',
        'period_end',
        'location',
    ];

    public function sections()
    {
        return $this->hasOne(ReportSection::class);
    }

    public function recommendations()
    {
        return $this->hasMany(ReportRecommendation::class);
    }
}
