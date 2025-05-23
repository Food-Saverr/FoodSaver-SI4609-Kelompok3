<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelUserLikeTable extends Migration
{
    public function up(): void
    {
        Schema::create('artikel_user_like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikels')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('penggunas', 'id_user')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['artikel_id','user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel_user_like');
    }
}
