<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatPakanHarian extends Model
{
    use HasFactory;

    // Nama tabel (jika berbeda dari nama model)
    protected $table = 'catat_pakan_harian';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'farms_id',
        'kolam_id',
        'siklus_id',
        'jadwal_pertama',
        'jumlah_pakan_pertama',
        'jadwal_kedua',
        'jumlah_pakan_kedua',
        'jadwal_ketiga',
        'jumlah_pakan_ketiga',
        'jadwal_keempat',
        'jumlah_pakan_keempat',
        'jadwal_kelima',
        'jumlah_pakan_kelima',
        'tanggal',
    ];

    // Relasi ke tabel farms
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    // Relasi ke tabel kolam
    public function kolam()
    {
        return $this->belongsTo(Kolam::class, 'kolam_id');
    }

    // Relasi ke tabel siklus
    public function siklus()
    {
        return $this->belongsTo(Siklus::class, 'siklus_id');
    }
}