<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranTable extends Migration
{
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farms_id');
            $table->enum('jenis_pengeluaran', ['biaya_pakan', 'biaya_bibit', 'gaji_pekerja', 'biaya_perawatan', 'biaya_lainnya']);
            $table->decimal('jumlah_pengeluaran', 15, 2);
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('farms_id')->references('id')->on('farms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
}
