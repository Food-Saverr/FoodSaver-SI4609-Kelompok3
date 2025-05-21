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
        Schema::create('expired_reminder_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makanan_id')->constrained('makanans', 'ID_Makanan')->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->timestamp('send_at');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expired_reminder_notifications');
    }
};
