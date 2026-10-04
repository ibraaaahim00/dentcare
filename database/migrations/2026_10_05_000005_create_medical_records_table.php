<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->text('diagnosis');
            $table->text('treatment');
            $table->text('notes')->nullable();
            $table->date('treatment_date');
            $table->timestamps();

            $table->index(['patient_id', 'treatment_date']);
            $table->index(['doctor_id', 'treatment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
