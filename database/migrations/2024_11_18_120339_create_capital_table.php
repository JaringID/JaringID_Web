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
        Schema::create('capital', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('farm_id')->constrained()->onDelete('cascade'); // Relasi ke farm
            $table->decimal('feed_cost', 10, 2); // Biaya pakan
            $table->decimal('seed_cost', 10, 2); // Biaya bibit
            $table->decimal('pond_cost', 10, 2); // Biaya tambak
            $table->decimal('salary_cost', 10, 2); // Biaya gaji
            $table->decimal('operational_cost', 10, 2); // Biaya operasional
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capital');
    }
};
