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
            
            // FK to artikels.id
            $table->foreignId('artikel_id')
                  ->constrained('artikels')
                  ->cascadeOnDelete();
            
            // FK to penggunas.user_id  ← notice two args here
            $table->foreignId('user_id')
                  ->constrained('penggunas', 'user_id')
                  ->cascadeOnDelete();
            
            $table->timestamps();
            
            // prevent duplicate likes
            $table->unique(['artikel_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel_user_like');
    }
}
