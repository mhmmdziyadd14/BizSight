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
        Schema::table('hpp_calculations', function (Blueprint $table) {
            if (!Schema::hasColumn('hpp_calculations', 'branding_fee')) {
                $table->decimal('branding_fee', 15, 2)->default(0)->after('total_raw_material_cost');
            }
            if (!Schema::hasColumn('hpp_calculations', 'calculation_type')) {
                $table->string('calculation_type', 50)->default('calculated')->after('category');
            }
            if (!Schema::hasColumn('hpp_calculations', 'manual_hpp')) {
                $table->decimal('manual_hpp', 15, 2)->nullable()->after('calculation_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hpp_calculations', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('hpp_calculations', 'branding_fee')) $cols[] = 'branding_fee';
            if (Schema::hasColumn('hpp_calculations', 'calculation_type')) $cols[] = 'calculation_type';
            if (Schema::hasColumn('hpp_calculations', 'manual_hpp')) $cols[] = 'manual_hpp';
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
