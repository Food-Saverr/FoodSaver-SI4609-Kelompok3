<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('penggunas', 'ID_Pengguna')->onDelete('cascade');
            $table->boolean('request_status')->default(true); // Notifications for request status changes
            $table->boolean('new_requests')->default(true); // Notifications for new food requests
            $table->boolean('maintenance')->default(true); // System maintenance notifications
            $table->boolean('announcements_enabled')->default(true); // Notifications for announcements
            $table->boolean('ads_enabled')->default(true); // Notifications for ads
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_preferences');
    }
}; 