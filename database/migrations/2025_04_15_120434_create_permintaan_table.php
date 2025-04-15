<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id('ID_Permintaan');
            $table->enum('Status_Permintaan', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamp('Waktu_Permintaan')->useCurrent();
            $table->unsignedBigInteger('ID_Pengguna');
            $table->unsignedBigInteger('ID_Makanan');
            $table->timestamps();

            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('penggunas')->onDelete('cascade');
            $table->foreign('ID_Makanan')->references('ID_Makanan')->on('makanans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};
