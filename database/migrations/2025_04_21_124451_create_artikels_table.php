<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id('ID_Artikel');
            $table->string('Judul_Artikel');
            $table->text('Isi_Artikel');
            $table->unsignedBigInteger('ID_Pengguna'); // foreign key ke pengguna
            $table->timestamps();
        
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('penggunas')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
