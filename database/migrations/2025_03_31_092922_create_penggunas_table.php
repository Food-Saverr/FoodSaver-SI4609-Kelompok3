<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id(); // ← ini WAJIB supaya bisa jadi foreign key
            $table->string('Nama_Pengguna');
            $table->string('Email_Pengguna')->unique();
            $table->string('Password_Pengguna');
            $table->string('Alamat_Pengguna')->nullable();
            $table->string('Role_Pengguna')->default('User');
            $table->timestamps();
        });
        
    }
    
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
