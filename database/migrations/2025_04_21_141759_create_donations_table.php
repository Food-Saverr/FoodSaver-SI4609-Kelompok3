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
            $table->foreignId('id_user')->constrained('penggunas', 'id_user')->onDelete('cascade');
            $table->string('full_name');
            $table->string('phone');
            $table->decimal('nominal', 15, 2);
            $table->text('note')->nullable();
            $table->enum('status', ['Pending', 'Disetujui'])->default('Pending');
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'e-wallet']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
