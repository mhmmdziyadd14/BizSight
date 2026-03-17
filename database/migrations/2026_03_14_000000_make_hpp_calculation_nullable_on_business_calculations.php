<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_calculations', function (Blueprint $table) {
            // drop foreign key on hpp_calculation_id if it exists
            $table->dropForeign(['hpp_calculation_id']);
            // make column nullable
            $table->unsignedBigInteger('hpp_calculation_id')->nullable()->change();
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