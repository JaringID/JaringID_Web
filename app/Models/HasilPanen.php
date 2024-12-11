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
    public static function boot()
    {
        parent::boot();
    
        static::saving(function ($model) {
            if ($model->total_berat && $model->harga_per_kg) {
                // Periksa jenis panen
                if ($model->jenis_panen == 'Parsial') {
                    // Jika jenis panen Parsial, hitung dengan pengurangan (misal 0.75)
                    $model->total_harga = $model->total_berat * $model->harga_per_kg; // Ganti 0.75 dengan faktor yang sesuai
                } else {
                    // Jika jenis panen Total atau Gagal, hitung harga tanpa pengurangan
                    $model->total_harga = $model->total_berat * $model->harga_per_kg;
                }
            }
            if ($model->jenis_panen) {
                $status = 'sedang_berjalan'; // default

                if ($model->jenis_panen == 'total') {
                    $status = 'selesai';
                } elseif ($model->jenis_panen == 'gagal') {
                    $status = 'berhenti';
                }

                // Update status di siklus terkait
                $model->siklus->update(['status' => $status]);
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
