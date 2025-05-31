<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expired_food_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Makanan');
            $table->string('Nama_Makanan');
            $table->text('Deskripsi_Makanan')->nullable();
            $table->string('Kategori_Makanan')->nullable();
            $table->string('Foto_Makanan')->nullable();
            $table->dateTime('Tanggal_Kedaluwarsa');
            $table->integer('Jumlah_Makanan');
            $table->integer('Jumlah_Didonasi')->default(0);
            $table->unsignedBigInteger('id_user');
            $table->timestamp('expired_at');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id_user')->on('penggunas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expired_food_history');
    }
}; 