<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = [
        'nama',
        'image',
        'deskripsi',
    ];
/**
     * Mutator untuk memastikan path gambar tidak memiliki karakter tambahan.
     *
     * @param string|null $value
     */
    public function saveImage($file)
{
    return $file->store('penyakit-images', 'public'); // Menyimpan gambar di disk 'public' dalam folder 'penyakit-images'
}

public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
        return null;
    }




    /**
     * Event Listener: Menghapus file lama saat gambar diperbarui.
     */
    protected static function booted()
    {
        // Saat model diupdate
        static::updating(function ($penyakit) {
            if ($penyakit->isDirty('image')) {
                // Hapus file gambar lama jika ada
                Storage::delete($penyakit->getOriginal('image'));
            }
        });

        // Saat model dihapus
        static::deleting(function ($penyakit) {
            // Hapus file gambar jika ada
            Storage::delete($penyakit->image);
        });
    }
}