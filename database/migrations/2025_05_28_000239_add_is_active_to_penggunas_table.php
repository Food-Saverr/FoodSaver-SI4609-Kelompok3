<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToPenggunasTable extends Migration
{
    public function up()
    {
        // Menambahkan kolom is_active
        Schema::table('penggunas', function (Blueprint $table) {
            $table->boolean('is_active')->default(true); // Defaultnya adalah aktif
        });
    }

    public function down()
    {
        // Menghapus kolom is_active jika migration di rollback
        Schema::table('penggunas', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
