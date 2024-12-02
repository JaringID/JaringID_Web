<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {Schema::create('kolams', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kolam');
        $table->enum('tipe_kolam', ['kotak', 'bulat']);
        $table->float('panjang_kolam')->nullable(); // untuk tipe kotak
        $table->float('lebar_kolam')->nullable(); // untuk tipe kotak
        $table->float('diameter_kolam')->nullable(); // untuk tipe bulat
        $table->float('kedalaman_kolam');
        $table->foreignId('farm_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kolams');
    }
};
