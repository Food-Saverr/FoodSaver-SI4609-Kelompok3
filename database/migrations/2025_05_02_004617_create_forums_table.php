<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true); // Untuk status diskusi aktif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
