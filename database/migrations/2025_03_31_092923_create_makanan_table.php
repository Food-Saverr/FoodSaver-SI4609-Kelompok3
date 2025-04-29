<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('makanan', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Makanan');
            $table->integer('Jumlah_Tersedia')->default(0);
            $table->integer('Jumlah_Didonasi')->default(0);
            $table->string('status')->default('tersedia');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('ID_Pengguna')->on('penggunas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('makanan');
    }
}; 