<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendapatanTable extends Migration
{
    public function up()
    {
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farms_id');
            $table->decimal('saldo', 15, 2)->nullable();;
            $table->decimal('pendapatan', 15, 2)->nullable();;
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('farms_id')->references('id')->on('farms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendapatan');
    }
}
