<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumReportsTable extends Migration
{
    public function up()
    {
        Schema::create('forum_reports', function (Blueprint $table) {
            $table->id('ID_Report');
            $table->unsignedBigInteger('ID_ForumPost');
            $table->unsignedBigInteger('id_user'); // Reporter ID
            $table->string('alasan_laporan');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'rejected', 'actioned'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('ID_Admin')->nullable(); // Admin who handled the report
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
            
            $table->foreign('ID_ForumPost')->references('ID_ForumPost')->on('forum_posts')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('penggunas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_reports');
    }
}