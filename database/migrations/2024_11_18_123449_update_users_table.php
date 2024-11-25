<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Menambahkan kolom profile_picture tanpa 'after'
        $table->string('profile_picture')->nullable(); // Menambahkan kolom untuk foto profil
        // Menambahkan kolom status tanpa 'after'
        $table->enum('status', ['active', 'inactive'])->default('active'); // Menambahkan kolom status
    });
}


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_picture'); // Menghapus kolom profile_picture
            $table->dropColumn('status'); // Menghapus kolom status
        });
    }
}
