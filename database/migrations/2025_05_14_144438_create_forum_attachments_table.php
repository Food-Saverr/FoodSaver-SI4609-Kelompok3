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
        Schema::create('forum_attachments', function (Blueprint $table) {
            $table->id('ID_Attachment');
            $table->unsignedBigInteger('ID_ForumPost');
            $table->string('nama_file');
            $table->string('path');
            $table->string('tipe_file');
            $table->integer('ukuran')->comment('ukuran dalam bytes');
            $table->timestamps();
            
            $table->foreign('ID_ForumPost')
                ->references('ID_ForumPost')
                ->on('forum_posts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_attachments');
    }
};