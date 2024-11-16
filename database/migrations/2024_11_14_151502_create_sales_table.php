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
        
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->foreignId('farm_id')->constrained()->onDelete('cascade');
        $table->foreignId('harvest_id')->constrained()->onDelete('cascade');
        $table->date('sale_date');
        $table->decimal('quantity', 10, 2); // jumlah yang terjual
        $table->decimal('price', 10, 2); // harga per unit
        $table->decimal('total_amount', 10, 2); // total jumlah uang
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
