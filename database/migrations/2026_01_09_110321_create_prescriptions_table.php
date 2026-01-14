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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'waiting', 'processed', 'completed', 'cancelled'])->default('draft');
            $table->decimal('total_price', 12, 2)->default(0);
            $table->foreignId('pharmacist_id')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
