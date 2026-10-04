<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('specialization');
            $table->string('specialization_ar')->nullable();
            $table->string('specialization_en')->nullable();
            $table->text('bio')->nullable();
            $table->text('bio_ar')->nullable();
            $table->text('bio_en')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('qualifications_ar')->nullable();
            $table->text('qualifications_en')->nullable();
            $table->unsignedInteger('experience_years')->default(0);
            $table->decimal('consultation_fee', 8, 2)->default(0.00);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
