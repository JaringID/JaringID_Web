<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'harvest_id',
        'sale_date',
        'quantity',
        'price',
        'total_amount',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function harvest()
    {
        return $this->belongsTo(Harvest::class);
    }

    // Event untuk menghitung total_amount otomatis
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sales) {
            $sales->total_amount = $sales->price * $sales->quantity;
        });
    }
}
