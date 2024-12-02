<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolam extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kolam',
        'tipe_kolam',
        'panjang_kolam',
        'lebar_kolam',
        'diameter_kolam',
        'kedalaman_kolam',
        'farm_id',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    public function kolams()
{
    return $this->hasMany(Kolam::class);
}

}

