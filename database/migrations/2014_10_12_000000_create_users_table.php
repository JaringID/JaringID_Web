<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone_number')->unique(); // Hapus 'after' di sini
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->enum('role', ['owner', 'farm_manager', 'employee'])->default('employee');
        $table->foreignId('farm_id')->constrained()->onDelete('cascade'); // Relasi ke tabel farms
        $table->string('profile_picture')->nullable(); // Hapus 'after' di sini
        $table->rememberToken();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
