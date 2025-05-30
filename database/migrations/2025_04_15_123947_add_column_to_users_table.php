<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->integer('donasi_count')->default(0);
        });
        
    }

    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'donasi_count')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('donasi_count');
            });
        }
    }
};
