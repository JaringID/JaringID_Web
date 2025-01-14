<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';

    protected $fillable = [
        'farms_id',
        'saldo',
        'pendapatan',
        'tanggal',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farms_id');
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'farms_id', 'farms_id');
    }

    public function getSaldoAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }

    public function getPendapatanAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }

    public function setSaldoAttribute($value)
    {
        $this->attributes['saldo'] = round($value, 2);
    }

    public function setPendapatanAttribute($value)
    {
        $this->attributes['pendapatan'] = round($value, 2);
    }
}
