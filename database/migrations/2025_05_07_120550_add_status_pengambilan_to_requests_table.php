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
        Schema::table('requests', function (Blueprint $table) {
            $table->enum('Status_Pengambilan', ['Belum_Dijadwalkan', 'Dijadwalkan', 'Siap_Diambil', 'Sudah_Diambil', 'Dibatalkan'])->default('Belum_Dijadwalkan')->after('Status_Request');
            $table->text('Catatan_Pembatalan')->nullable()->after('Alamat_Pengambilan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['Status_Pengambilan', 'Catatan_Pembatalan']);
        });
    }
};
