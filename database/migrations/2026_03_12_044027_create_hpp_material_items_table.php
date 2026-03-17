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
    Schema::create('hpp_material_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hpp_calculation_id')->constrained()->onDelete('cascade');
        $table->foreignId('material_id')->constrained();
        $table->decimal('usage_amount', 10, 2); // Kebutuhan bahan per unit
        $table->decimal('subtotal_cost', 15, 2); // Harga Satuan x Usage
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpp_material_items');
    }
};
