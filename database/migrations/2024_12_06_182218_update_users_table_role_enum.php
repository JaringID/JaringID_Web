<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Perbarui enum dengan menambahkan 'technician' tanpa menghapus role lainnya
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('owner', 'farm_manager', 'employee', 'technician') DEFAULT 'employee'");
    }

    public function down(): void
    {
        // Rollback ke enum asli tanpa 'technician' dan 'worker'
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('owner', 'farm_manager', 'employee') DEFAULT 'employee'");
    }
};
