<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelsTable extends Migration
{
    public function up()
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();

            // Judul dan slug unik
            $table->string('judul');
            $table->string('slug')->unique();

            // Konten dan gambar
            $table->text('konten');
            $table->string('gambar')->nullable();

            // Penulis (hanya admin yang bisa buat)
            $table->foreignId('user_id')
                  ->constrained('penggunas', 'id_user')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikels');
    }
}