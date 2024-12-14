<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePendapatanTable extends Migration
{
    public function up()
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            // Menambahkan default value untuk kolom saldo dan pendapatan
            $table->decimal('saldo', 15, 2)->default(0)->change();
            $table->decimal('pendapatan', 15, 2)->default(0)->change();

            // Menambahkan unique constraint pada kombinasi farms_id dan tanggal
            $table->unique(['farms_id', 'tanggal'], 'unique_farm_tanggal');

            // Menambahkan indeks untuk farms_id dan tanggal
            $table->index(['farms_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::table('pendapatan', function (Blueprint $table) {
            // Menghapus unique constraint
            $table->dropUnique('unique_farm_tanggal');

            // Menghapus indeks farms_id dan tanggal
            $table->dropIndex(['farms_id', 'tanggal']);

            // Mengembalikan perubahan default value
            $table->decimal('saldo', 15, 2)->nullable()->change();
            $table->decimal('pendapatan', 15, 2)->nullable()->change();
        });
    }
}
