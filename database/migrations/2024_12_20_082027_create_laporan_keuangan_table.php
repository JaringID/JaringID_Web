<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKeuanganTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farms_id'); // Relasi ke tabel farms
            $table->integer('year'); // Tahun laporan
            $table->integer('month'); // Bulan laporan

            // Kolom total pendapatan dan pengeluaran
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('total_pengeluaran', 15, 2)->default(0);
            $table->decimal('keuntungan_bersih', 15, 2)->default(0);

            // Rincian per jenis pengeluaran
            $table->decimal('total_biaya_bibit', 15, 2)->default(0);
            $table->decimal('total_biaya_pakan', 15, 2)->default(0);
            $table->decimal('total_gaji_karyawan', 15, 2)->default(0);
            $table->decimal('total_biaya_perawatan', 15, 2)->default(0);
            $table->decimal('total_biaya_lainnya', 15, 2)->default(0);

            $table->timestamps(); // Untuk created_at dan updated_at

            // Foreign key constraint
            $table->foreign('farms_id')->references('id')->on('farms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_keuangan');
    }
}
