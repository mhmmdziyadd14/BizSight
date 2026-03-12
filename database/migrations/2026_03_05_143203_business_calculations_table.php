<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_calculations', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke user (karena kamu sudah install Breeze)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('product_name');
            $table->decimal('hpp', 15, 2);
            $table->decimal('selling_price', 15, 2);
            $table->decimal('ads_per_unit', 15, 2);
            $table->decimal('operational_fee', 15, 2);
            $table->integer('est_batch_quantity');
            
            // Hasil Hitungan
            $table->decimal('net_profit', 15, 2);
            $table->decimal('net_margin_percent', 5, 2);
            $table->integer('bep_unit');
            
            // Output Visual & Logic
            $table->string('status_label');
            $table->text('logic_reason')->nullable();
            $table->text('action_required')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_calculations');
    }
};