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
        'keliling_kolam',
        'diameter_kolam',
        'kedalaman_kolam',
        'farm_id',
    ];

    protected static function boot()
    {
        parent::boot();

        // Hitung keliling kolam sebelum data disimpan
        static::saving(function ($kolam) {
            if ($kolam->tipe_kolam === 'kotak' && $kolam->panjang_kolam && $kolam->lebar_kolam) {
                $kolam->keliling_kolam = (2 * $kolam->panjang_kolam) + (2 * $kolam->lebar_kolam);
            } else {
                $kolam->keliling_kolam = null;
            }
        });
    }

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
    public function siklus()
{
    return $this->hasMany(Siklus::class);
}

}

