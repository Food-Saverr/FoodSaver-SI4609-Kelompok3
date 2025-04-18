<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->timestamp('Waktu_Pengambilan')->nullable()->after('Waktu_Permintaan');
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn('Waktu_Pengambilan');
        });
    }
};
