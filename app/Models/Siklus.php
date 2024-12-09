<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siklus extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'siklus';

    // Kolom yang boleh diisi
    protected $fillable = [
        'farm_id',
        'user_id',
        'kolam_id',
        'total_lebar',
        'tipe_lebar',
        'tanggal_tebar',
        'total_pakan',
        'biaya_pakan',
        'total_bibit',
        'biaya_bibit',
        'biaya_perawatan',
    ];

    /**
     * Relasi ke tabel `farm`.
     */
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * Relasi ke tabel `user`.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel `kolam`.
     */
    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
}
