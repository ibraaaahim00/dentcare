<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_interval')->default(30);
            $table->unsignedInteger('minimum_notice_hours')->default(2);
            $table->unsignedInteger('maximum_days_ahead')->default(30);
            $table->unsignedInteger('cancellation_hours')->default(4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_settings');
    }
};
