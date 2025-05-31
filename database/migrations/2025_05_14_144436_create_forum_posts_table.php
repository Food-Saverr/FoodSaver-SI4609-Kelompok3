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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id('ID_ForumPost');
            $table->unsignedBigInteger('id_user');
            $table->string('judul');
            $table->text('konten');
            $table->boolean('is_reported')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
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
        Schema::dropIfExists('forum_posts');
    }
};