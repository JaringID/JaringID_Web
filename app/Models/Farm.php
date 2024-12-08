<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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
}

