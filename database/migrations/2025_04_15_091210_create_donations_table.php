<?php

namespace App\Models;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ID_Pengguna')->constrained('penggunas', 'ID_Pengguna')->onDelete('cascade');
            $table->string('full_name');
            $table->string('phone');
            $table->decimal('nominal', 15, 2);
            $table->text('note')->nullable();
            $table->enum('status', ['Pending', 'Disetujui'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
