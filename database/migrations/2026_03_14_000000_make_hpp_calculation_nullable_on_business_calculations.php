<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_calculations', function (Blueprint $table) {
            // Make the foreign key column optional so Business Checker can store calculations
            // even if tidak ada HPP yang dipilih.
            if (Schema::hasColumn('business_calculations', 'hpp_calculation_id')) {
                $table->unsignedBigInteger('hpp_calculation_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('business_calculations', function (Blueprint $table) {
            // revert to not null and restore constraint
            $table->unsignedBigInteger('hpp_calculation_id')->nullable(false)->change();
            $table->foreign('hpp_calculation_id')->references('id')->on('hpp_calculations')->onDelete('cascade');
        });
    }
};