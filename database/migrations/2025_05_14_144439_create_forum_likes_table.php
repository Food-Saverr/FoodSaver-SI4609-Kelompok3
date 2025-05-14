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
        Schema::create('forum_likes', function (Blueprint $table) {
            $table->id('ID_Like');
            $table->unsignedBigInteger('ID_ForumPost');
            $table->unsignedBigInteger('ID_Pengguna');
            $table->timestamps();
            
            $table->foreign('ID_ForumPost')
                ->references('ID_ForumPost')
                ->on('forum_posts')
                ->onDelete('cascade');
                
            $table->foreign('ID_Pengguna')
                ->references('ID_Pengguna')
                ->on('penggunas')
                ->onDelete('cascade');
                
            // Memastikan satu pengguna hanya bisa like sekali per post
            $table->unique(['ID_ForumPost', 'ID_Pengguna']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_likes');
    }
};