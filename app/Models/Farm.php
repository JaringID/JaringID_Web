<?php

namespace App\Models;

use App\Models\Siklus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lokasi',
        'description',
        'user_id', // Pastikan user_id ada di tabel farms
    ];

    // Relasi dengan User
    public function user() // Singular, karena satu farm hanya dimiliki oleh satu user
    {
        return $this->belongsTo(User::class); // Relasi belongsTo ke model User
    }
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
    public function kolams()
    {
        return $this->hasMany(Kolam::class, 'farm_id');
    }

    public function siklus()
    {
        return $this->hasMany(Siklus::class, 'siklus_id');
    }

    public function pendapatan()
    {
        return $this->hasMany(Pendapatan::class, 'farms_id');
    }

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'farms_id');
    }

    public function laporanKeuangan()
    {
        return $this->hasMany(LaporanKeuangan::class, 'farms_id');
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'farm_user')
            ->withTimestamps();
    }
}
