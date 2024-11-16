<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',       // untuk relasi ke farm
        'sale_date',     // tanggal penjualan
        'quantity',      // jumlah yang terjual
        'price',         // harga per unit
        'total_amount',  // total uang yang diterima dari penjualan
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function harvest()
    {
        return $this->belongsTo(Harvest::class);
    }
}
