<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id('ID_Pengguna');
            $table->string('Nama_Pengguna');
            $table->string('Email_Pengguna')->unique();
            $table->string('Password_Pengguna');
            $table->text('Alamat_Pengguna');
            $table->enum('Role_Pengguna', ['Admin', 'Donatur', 'Pengguna'])->default('Pengguna');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penggunas');
    }
};
