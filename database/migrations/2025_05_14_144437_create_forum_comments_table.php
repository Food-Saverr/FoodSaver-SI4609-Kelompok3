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
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id('ID_Comment');
            $table->unsignedBigInteger('ID_ForumPost');
            $table->unsignedBigInteger('id_user');
            $table->text('konten');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('ID_ForumPost')
                ->references('ID_ForumPost')
                ->on('forum_posts')
                ->onDelete('cascade');
                
            $table->foreign('id_user')
                ->references('id_user')
                ->on('penggunas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_comments');
    }
};