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
        Schema::create('users', function (Blueprint $table) {
            $table->id('ID_Pengguna');
            $table->string('Nama_Pengguna');
            $table->string('Email_Pengguna')->unique();
            $table->string('Password_Pengguna');
            $table->text('Alamat_Pengguna');
            $table->enum('Role_Pengguna', ['Pengguna', 'Donatur', 'Admin'])->default('Pengguna');
            $table->rememberToken()->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
