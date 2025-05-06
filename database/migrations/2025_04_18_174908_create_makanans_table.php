<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakanansTable extends Migration
{
    public function up()
    {
        Schema::create('makanans', function (Blueprint $table) {
            $table->id('ID_Makanan');
            $table->string('Nama_Makanan');
            $table->text('Deskripsi_Makanan')->nullable();
            $table->string('Kategori_Makanan')->nullable();
            $table->string('Foto_Makanan')->nullable();
            $table->string('Status_Makanan')->nullable();
            $table->dateTime('Tanggal_Kedaluwarsa')->nullable();
            $table->string('Lokasi_Makanan')->nullable();
            $table->integer('Jumlah_Makanan')->nullable();
            $table->integer('Jumlah_Didonasi')->nullable();

            $table->unsignedBigInteger('id_user')->nullable(); // Bisa Donatur / Admin

            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('penggunas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('makanans');
    }
}
