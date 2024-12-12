<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPanen extends Model
{
    use HasFactory;

    /**
     * Tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'hasil_panens'; // Sesuaikan dengan nama tabel Anda.

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'farms_id',
        'kolams_id',
        'siklus_id',
        'tanggal_panen',
        'jenis_panen',
        'total_berat',
        'harga_per_kg',
        'total_harga',
        'pembeli',
        'catatan',
    ];
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Perbarui status Siklus dan Kolam berdasarkan jenis panen
            if ($model->jenis_panen === 'total' || $model->jenis_panen === 'gagal') {
                $model->siklus->update(['status_siklus' => 'berhenti']);
                $model->kolam->update(['status' => 'tidak_aktif']);
            } elseif ($model->jenis_panen === 'parsial') {
                $model->siklus->update(['status_siklus' => 'sedang_berjalan']);
                $model->kolam->update(['status' => 'aktif']);
            }
        });
    }

    


    /**
     * Relasi ke tabel Farm.
     */
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }

    /**
     * Relasi ke tabel Kolam.
     */
    public function kolam()
    {
        return $this->belongsTo(Kolam::class, 'kolams_id');
    }

    /**
     * Relasi ke tabel Siklus.
     */
    public function siklus()
    {
        return $this->belongsTo(Siklus::class, 'siklus_id');
    }
}
