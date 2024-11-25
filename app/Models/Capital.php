<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    use HasFactory;

    protected $table = 'capital';

    protected $fillable = [
        'farm_id',
        'feed_cost',
        'seed_cost',
        'pond_cost',
        'salary_cost',
        'operational_cost',
        'description',
    ];

    // Relasi ke Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
