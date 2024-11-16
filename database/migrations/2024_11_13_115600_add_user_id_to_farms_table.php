<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            // Menambahkan kolom user_id dan menjadikannya foreign key yang terhubung ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            // Menghapus kolom user_id jika migration dibatalkan
            $table->dropColumn('user_id');
        });
    }
};
