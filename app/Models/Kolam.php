<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kolam',
        'tipe_kolam',
        'panjang_kolam',
        'lebar_kolam',
        'diameter_kolam',
        'kedalaman_kolam',
        'farm_id',
    ];

    public function user() // Singular, karena satu farm hanya dimiliki oleh satu user
    {
        return $this->belongsTo(User::class); // Relasi belongsTo ke model User
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
    public function kolams()
{
    return $this->hasMany(Kolam::class);
}

}

