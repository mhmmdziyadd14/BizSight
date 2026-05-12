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
        Schema::create('visual_packs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hpp_calculation_id')->nullable()->constrained('hpp_calculations')->nullOnDelete();
            $table->string('name')->default('Visual Pack');
            $table->json('data')->nullable(); // Stores all form data
            $table->json('images')->nullable(); // Stores all image paths
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visual_packs');
    }
};
