<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pindahkan use ke sini
use App\Models\Farm; // Tambahkan jika Anda juga menggunakan model Farm

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat akun pengguna dengan role admin
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'farm_manager',
            'farm_id' => null, // Kosongkan farm_id untuk sementara
            'phone_number' => '081234567890',
        ]);

        // Membuat farm yang terkait dengan user
        $farm = Farm::create([
            'name' => 'Default Farm',
    'user_id' => $user->id,
    'kolam' => '5',
        ]);

        // Perbarui user dengan farm_id
        $user->update([
            'farm_id' => $farm->id,
        ]);
    }
}
