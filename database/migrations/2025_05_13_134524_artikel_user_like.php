<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelUserLikeTable extends Migration
{
    public function up()
    {
        Schema::create('artikel_user_like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')
                  ->constrained('artikels')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['artikel_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel_user_like');
    }
}
