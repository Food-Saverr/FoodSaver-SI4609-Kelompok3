<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id('ID_Request');
            $table->unsignedBigInteger('ID_Makanan');
            $table->unsignedBigInteger('id_user');
            $table->text('Pesan')->nullable();
            $table->enum('Status_Request', ['Pending', 'Approved', 'Rejected', 'Done'])->default('Pending');
            $table->timestamps();

            $table->foreign('ID_Makanan')->references('ID_Makanan')->on('makanans')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('penggunas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
