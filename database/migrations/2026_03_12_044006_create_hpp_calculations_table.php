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
    Schema::create('hpp_calculations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('hpp_id')->unique(); // ID Manual (Contoh: BZS-001)
        $table->string('name');
        $table->string('category');
        $table->decimal('total_raw_material_cost', 15, 2);
        $table->decimal('screen_printing_fee', 15, 2)->default(0);
        $table->decimal('sewing_fee', 15, 2)->default(0);
        $table->decimal('other_fees', 15, 2)->default(0);
        $table->decimal('total_hpp_per_unit', 15, 2);
        $table->decimal('target_selling_price', 15, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpp_calculations');
    }
};
