<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dateTime('Waktu_Pengambilan')->nullable();
            $table->text('Alamat_Pengambilan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['Waktu_Pengambilan', 'Alamat_Pengambilan']);
        });
    }
}; 