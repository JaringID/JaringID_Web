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
        Schema::table('siklus', function (Blueprint $table) {
            // Rename column 'total_lebar' to 'total_tebar'
            $table->renameColumn('total_lebar', 'total_tebar');

            // Rename column 'tipe_lebar' to 'tipe_tebar'
            $table->renameColumn('tipe_lebar', 'tipe_tebar');

            // Remove unnecessary columns
            $table->dropColumn(['total_pakan', 'biaya_pakan', 'total_bibit', 'biaya_bibit', 'biaya_perawatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siklus', function (Blueprint $table) {
            // Rename column 'total_tebar' back to 'total_lebar'
            $table->renameColumn('total_tebar', 'total_lebar');

            // Rename column 'tipe_tebar' back to 'tipe_lebar'
            $table->renameColumn('tipe_tebar', 'tipe_lebar');

            // Add back the dropped columns
            $table->integer('total_pakan');
            $table->double('biaya_pakan', 15, 2);
            $table->integer('total_bibit');
            $table->double('biaya_bibit', 15, 2);
            $table->double('biaya_perawatan', 15, 2)->nullable();
        });
    }
};