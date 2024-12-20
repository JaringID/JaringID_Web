<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;
    protected $table = 'monthly_report';

    protected $fillable = [
        'farms_id',
        'kolams_id',
        'siklus_id',
        'hasil_panens_id',
        'catat_pakan_harian_id',
        'report_month',
        'details',
    ];

    // Relasi ke Farm
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    // Relasi ke Kolam
    public function kolam()
    {
        return $this->belongsTo(Kolam::class, 'kolams_id');
    }

    // Relasi ke Siklus
    public function siklus()
    {
        return $this->belongsTo(Siklus::class, 'siklus_id');
    }

    // Relasi ke Catat Pakan Harian
    public function catatPakanHarian()
    {
        return $this->belongsTo(CatatPakanHarian::class, 'catat_pakan_harian_id');
    }
    public function hasilPanen()
    {
        return $this->belongsTo(HasilPanen::class, 'hasil_panens_id');
    }
    public function getHasilPanenTanggalPanenAttribute()
    {
        return $this->hasilPanen->tanggal_panen ?? null;
    }

    // Accessor untuk jenis_panen
    public function getHasilPanenJenisPanenAttribute()
    {
        return $this->hasilPanen->jenis_panen ?? null;
    }

    // Accessor untuk total_berat
    public function getHasilPanenTotalBeratAttribute()
    {
        return $this->hasilPanen->total_berat ?? null;
    }

    // Accessor untuk pembeli
    public function getHasilPanenPembeliAttribute()
    {
        return $this->hasilPanen->pembeli ?? null;
    }
}
