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
        // Jika siklus pertama kali dibuat, ubah status kolam menjadi 'aktif'
        if ($siklus->kolam && $siklus->kolam->status === 'belum_aktif') {
            $siklus->kolam->setStatusAktif();
        }
    });

    static::updated(function ($siklus) {
        // Jika status siklus berubah menjadi 'berhenti', ubah status kolam menjadi 'tidak_aktif'
        if ($siklus->isDirty('status_siklus') && $siklus->status_siklus === 'berhenti') {
            if ($siklus->kolam) {
                $siklus->kolam->update(['status' => 'tidak_aktif']);
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
        $hasilPanen = $this->hasilPanen;

        if (!$hasilPanen) {
            throw new \Exception('Data hasil panen tidak ditemukan.');
        }

        $jenisPanen = $hasilPanen->jenis_panen;

        if ($jenisPanen === 'parsial') {
            // Tetap berjalan, kolam tetap aktif
            $this->update(['status_siklus' => 'sedang_berjalan']);
        } elseif (in_array($jenisPanen, ['total', 'gagal'])) {
            // Siklus berhenti, kolam tidak aktif
            $this->update(['status_siklus' => 'berhenti']);
            $this->kolam->setStatusTidakAktif();
        }
    }
}
