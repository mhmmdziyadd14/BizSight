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
        Schema::table('materials', function (Blueprint $table) {
            if (! Schema::hasColumn('materials', 'stock_initial')) {
                $table->decimal('stock_initial', 10, 2)->default(0)->after('unit');
            }
            if (! Schema::hasColumn('materials', 'stock_in')) {
                $table->decimal('stock_in', 10, 2)->default(0)->after('stock_initial');
            }
            if (! Schema::hasColumn('materials', 'stock_out')) {
                $table->decimal('stock_out', 10, 2)->default(0)->after('stock_in');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            if (Schema::hasColumn('materials', 'stock_out')) {
                $table->dropColumn('stock_out');
            }
            if (Schema::hasColumn('materials', 'stock_in')) {
                $table->dropColumn('stock_in');
            }
            if (Schema::hasColumn('materials', 'stock_initial')) {
                $table->dropColumn('stock_initial');
            }
        });
    }
};
