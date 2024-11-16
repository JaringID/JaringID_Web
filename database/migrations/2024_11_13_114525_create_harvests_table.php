<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('harvests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('farm_id')->constrained()->onDelete('cascade');
        $table->date('harvest_date');
        $table->decimal('quantity', 10, 2); // bisa menyesuaikan dengan satuan hasil panen
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
