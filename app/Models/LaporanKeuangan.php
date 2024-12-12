<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuangan';
    protected $fillable = [
        'farms_id',
        'id_pendapatan',
        'id_pengeluaran',
        'saldo',
        'total_pendapatan',
        'total_pengeluaran',
        'keuntungan_bersih',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    public function pendapatan()
    {
        return $this->belongsTo(Pendapatan::class, 'id_pendapatan');
    }

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'id_pengeluaran');
    }
}
