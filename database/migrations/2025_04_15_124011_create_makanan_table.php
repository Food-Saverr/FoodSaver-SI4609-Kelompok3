<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('makanan', function (Blueprint $table) {
            $table->id('ID_Makanan');
            $table->string('Nama_Makanan');
            $table->integer('Jumlah_Tersedia');
            $table->integer('Jumlah_Didonasi');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makanan');
    }
};
