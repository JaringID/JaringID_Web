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
        Schema::create('siklus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade'); // Asumsi tabel farms
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Asumsi tabel users
            $table->foreignId('kolam_id')->constrained('kolams')->onDelete('cascade'); // Asumsi tabel kolams
            $table->integer('total_lebar'); // Total luas (Integer kecil)
            $table->enum('tipe_lebar', ['netto', 'bruto', 'aktual']); // Tipe luas (enum)
            $table->date('tanggal_tebar'); // Tanggal bibit ditebar
            $table->integer('total_pakan'); // Total pakan dalam satuan kecil
            $table->double('biaya_pakan', 15, 2); // Biaya pakan (angka desimal)
            $table->integer('total_bibit'); // Total bibit dalam unit
            $table->double('biaya_bibit', 15, 2); // Biaya bibit (angka desimal)
            $table->double('biaya_perawatan', 15, 2)->nullable(); // Biaya perawatan (opsional)
            $table->timestamps(); // created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siklus'); // Menghapus tabel jika di-rollback
    }
};
