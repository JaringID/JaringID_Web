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
            $table->unsignedBigInteger('farms_id');
            $table->unsignedBigInteger('id_pendapatan');
            $table->unsignedBigInteger('id_pengeluaran');
            $table->decimal('saldo', 15, 2);
            $table->decimal('total_pendapatan', 15, 2);
            $table->decimal('total_pengeluaran', 15, 2);
            $table->decimal('keuntungan_bersih', 15, 2);
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('farms_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('id_pendapatan')->references('id')->on('pendapatan')->onDelete('cascade');
            $table->foreign('id_pengeluaran')->references('id')->on('pengeluaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_keuangan');
    }
}
