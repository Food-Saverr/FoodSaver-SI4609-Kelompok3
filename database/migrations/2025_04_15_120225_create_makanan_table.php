<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('makanans', function (Blueprint $table) {
            $table->id('ID_Makanan');
            $table->string('Nama_Makanan');
            $table->text('Deskripsi_Makanan')->nullable();
            $table->string('Kategori_Makanan')->nullable();
            $table->string('Status_Makanan')->default('Tersedia');
            $table->dateTime('Tanggal_Kedaluwarsa')->nullable();
            $table->string('Lokasi_Makanan')->nullable();
            $table->unsignedBigInteger('ID_Pengguna');
            $table->timestamps();

            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('penggunas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makanans');
    }
};
