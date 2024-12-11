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
    {
        Schema::create('hasil_panens', function (Blueprint $table) {
            $table->id('id_panen');
            $table->foreignId('farms_id')->constrained('farms')->onDelete('cascade');
            $table->foreignId('kolams_id')->constrained('kolams')->onDelete('cascade');
            $table->foreignId('siklus_id')->constrained('siklus')->onDelete('cascade');
            $table->date('tanggal_panen');
            $table->enum('jenis_panen', ['Total', 'Parsial', 'Gagal']);
            $table->decimal('total_berat', 8, 2);
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('total_harga', 12, 2);
            $table->string('pembeli')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_panens');
    }
};
