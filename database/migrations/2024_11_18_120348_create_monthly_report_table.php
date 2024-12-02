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
        Schema::create('monthly_report', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('farm_id')->constrained()->onDelete('cascade'); // Relasi ke farm
            $table->date('report_month'); // Bulan laporan
            $table->decimal('income', 10, 2); // Pendapatan
            $table->decimal('expenses', 10, 2); // Pengeluaran
            $table->decimal('profit', 10, 2)->nullable();
            $table->text('details')->nullable(); // Detail laporan
            $table->enum('status', ['draft', 'finalized'])->default('draft'); // Status laporan
            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_report');
    }
};
