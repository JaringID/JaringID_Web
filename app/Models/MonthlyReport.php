<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $table = 'monthly_report';

    protected $fillable = [
        'farm_id',
        'report_month',
        'income',
        'expenses',
        'profit',
        'details',
        'status',
    ];

    // Relasi ke Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
