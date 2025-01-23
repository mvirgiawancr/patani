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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk');
            $table->decimal('harga_produk', 10, 2);
            $table->text('deskripsi');
            $table->integer('stok');
            $table->string('foto'); // Kolom untuk menyimpan path foto
            $table->unsignedBigInteger('id_user'); // Kolom id_user
            $table->foreign('id_user')           // Mendefinisikan foreign key
                  ->references('id_user')      // Menunjukkan bahwa ini merujuk ke kolom 'id_user' di tabel 'users'
                  ->on('users')                // Pada tabel 'users'
                  ->onDelete('cascade');       // Jika data di tabel 'users' dihapus, maka data di tabel 'produk' akan ikut terhapus
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
