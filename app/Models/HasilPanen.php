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

        static::saving(function ($model) {
            if ($model->total_berat && $model->harga_per_kg) {
                $model->total_harga = $model->total_berat * $model->harga_per_kg;
            }
        });

        // Handler untuk created dan updated
        static::saved(function ($model) {
            // Load relasi yang diperlukan
            if (!$model->relationLoaded('siklus')) {
                $model->load('siklus');
            }
            if (!$model->relationLoaded('kolam')) {
                $model->load('kolam');
            }

            \DB::transaction(function () use ($model) {
                if ($model->jenis_panen === 'total' || $model->jenis_panen === 'gagal') {
                    // Update siklus
                    if ($model->siklus) {
                        $model->siklus->update(['status_siklus' => 'berhenti']);
                    }

                    // Update kolam
                    if ($model->kolam) {
                        $model->kolam->setStatusTidakAktif();
                    }
                } elseif ($model->jenis_panen === 'parsial') {
                    // Jika parsial, pastikan status tetap aktif
                    if ($model->siklus) {
                        $model->siklus->update(['status_siklus' => 'sedang_berjalan']);
                    }
                    if ($model->kolam) {
                        $model->kolam->setStatusAktif();
                    }
                }
            });
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
