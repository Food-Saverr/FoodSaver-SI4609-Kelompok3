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
            $table->text('Alamat_Pengguna');
            $table->enum('Role_Pengguna', ['Pengguna','Donatur', 'Admin']);
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
        
    }
    
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
