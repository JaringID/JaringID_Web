<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $fillable = [
        'farms_id',
        'jenis_pengeluaran',
        'jumlah_pengeluaran',
        'tanggal',
    ];

    // Relasi ke tabel 'farms'
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }
}
