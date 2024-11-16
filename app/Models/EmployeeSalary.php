<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // untuk relasi ke tabel users
        'salary_amount', // gaji karyawan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

