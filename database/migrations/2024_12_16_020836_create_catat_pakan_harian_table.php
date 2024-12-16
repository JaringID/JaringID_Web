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
        Schema::create('catat_pakan_harian', function (Blueprint $table) {
            $table->id(); // id (long)
            $table->unsignedBigInteger('farms_id'); // farms_id (long) FK
            $table->unsignedBigInteger('kolam_id'); // kolam_id (long) FK

            // Jadwal pertama sampai kelima dan jumlah pakan
            $table->time('jadwal_pertama')->nullable();
            $table->double('jumlah_pakan_pertama')->nullable();

            $table->time('jadwal_kedua')->nullable();
            $table->double('jumlah_pakan_kedua')->nullable();

            $table->time('jadwal_ketiga')->nullable();
            $table->double('jumlah_pakan_ketiga')->nullable();

            $table->time('jadwal_keempat')->nullable();
            $table->double('jumlah_pakan_keempat')->nullable();

            $table->time('jadwal_kelima')->nullable();
            $table->double('jumlah_pakan_kelima')->nullable();

            $table->date('tanggal'); // tanggal (date)
            $table->timestamps(); // timestamps: created_at, updated_at

            // Foreign Key Constraints
            $table->foreign('farms_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('kolam_id')->references('id')->on('kolams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catat_pakan_harian');
    }
};