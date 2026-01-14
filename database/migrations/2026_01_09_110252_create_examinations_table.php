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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->datetime('examination_date');
            $table->decimal('height', 5, 2)->nullable(); // cm
            $table->decimal('weight', 5, 2)->nullable(); // kg
            $table->integer('systolic')->nullable(); // mmHg
            $table->integer('diastolic')->nullable(); // mmHg
            $table->integer('heart_rate')->nullable(); // bpm
            $table->integer('respiration_rate')->nullable(); // breaths/min
            $table->decimal('temperature', 4, 2)->nullable(); // celsius
            $table->text('doctor_notes');
            $table->string('external_file_path')->nullable();
            $table->enum('status', ['pending', 'processed', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
