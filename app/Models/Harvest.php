<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id', // untuk relasi ke farm
        'harvest_date', // tanggal panen
        'quantity', // jumlah hasil panen
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    public function sales()
{
    return $this->hasMany(Sales::class);
}
}

