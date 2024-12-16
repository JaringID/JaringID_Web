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
        'kolam_id',
        'total_tebar',
        'tipe_tebar',
        'tanggal_tebar',
        'status_siklus',
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
        return $this->belongsTo(Kolam::class, 'kolam_id');
    }

    /**
     * Relasi ke model `HasilPanen` untuk data hasil panen dari siklus ini.
     */
    public function hasilPanen()
    {
        return $this->hasOne(HasilPanen::class, 'siklus_id');
    }
    protected static function booted()
    {
        static::created(function ($siklus) {
            if ($siklus->kolam && $siklus->kolam->status === 'belum_aktif') {
                $siklus->kolam->setStatusAktif();
            }
        });

        static::updated(function ($siklus) {
            $siklus->load('kolam'); // Pastikan relasi kolam ter-load
            
            if ($siklus->isDirty('status_siklus')) {
                if ($siklus->status_siklus === 'berhenti') {
                    if ($siklus->kolam) {
                        $siklus->kolam->setStatusTidakAktif();
                    }
                } elseif ($siklus->status_siklus === 'sedang_berjalan') {
                    if ($siklus->kolam) {
                        $siklus->kolam->setStatusAktif();
                    }
                }
            }
        });
    }

    

    /**
     * Boot method untuk menangani logika terkait siklus dan kolam.
     */
    public static function boot()
    {
        parent::boot();

    }
    // Proses perubahan status setelah panen
    public function prosesPanen()
    {
        $this->load('hasilPanen', 'kolam'); // Load relasi yang diperlukan
        
        $hasilPanen = $this->hasilPanen;
        if (!$hasilPanen) {
            throw new \Exception('Data hasil panen tidak ditemukan.');
        }

        \DB::transaction(function () use ($hasilPanen) {
            if (in_array($hasilPanen->jenis_panen, ['total', 'gagal'])) {
                $this->update(['status_siklus' => 'berhenti']);
                if ($this->kolam) {
                    $this->kolam->setStatusTidakAktif();
                }
            } elseif ($hasilPanen->jenis_panen === 'parsial') {
                $this->update(['status_siklus' => 'sedang_berjalan']);
                if ($this->kolam) {
                    $this->kolam->setStatusAktif();
                }
            }
        });
    }
}
