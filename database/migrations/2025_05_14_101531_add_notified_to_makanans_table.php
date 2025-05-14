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
        Schema::table('makanans', function (Blueprint $table) {
            $table->boolean('notified')->default(false)->after('Tanggal_Kedaluwarsa');
        });
    }
    
    public function down(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            $table->dropColumn('notified');
        });
    }
    
};
