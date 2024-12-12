<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';
    protected $fillable = [
        'farms_id',
        'saldo',
        'pendapatan',
        'tanggal',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }
}
