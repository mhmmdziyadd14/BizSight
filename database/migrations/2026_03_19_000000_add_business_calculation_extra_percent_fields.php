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
        Schema::table('business_calculations', function (Blueprint $table) {
            if (! Schema::hasColumn('business_calculations', 'admin_fee_percent')) {
                $table->decimal('admin_fee_percent', 5, 2)->default(0)->after('ads_per_unit');
            }
            if (! Schema::hasColumn('business_calculations', 'overhead_percent')) {
                $table->decimal('overhead_percent', 5, 2)->default(0)->after('admin_fee_percent');
            }
            if (! Schema::hasColumn('business_calculations', 'tax_percent')) {
                $table->decimal('tax_percent', 5, 2)->default(0)->after('overhead_percent');
            }
            if (! Schema::hasColumn('business_calculations', 'promo_percent')) {
                $table->decimal('promo_percent', 5, 2)->default(0)->after('tax_percent');
            }
            if (! Schema::hasColumn('business_calculations', 'promo_margin_percent')) {
                $table->decimal('promo_margin_percent', 5, 2)->default(0)->after('net_margin_percent');
            }
            if (! Schema::hasColumn('business_calculations', 'margin_diff_percent')) {
                $table->decimal('margin_diff_percent', 5, 2)->default(0)->after('promo_margin_percent');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_calculations', function (Blueprint $table) {
            if (Schema::hasColumn('business_calculations', 'margin_diff_percent')) {
                $table->dropColumn('margin_diff_percent');
            }
            if (Schema::hasColumn('business_calculations', 'promo_margin_percent')) {
                $table->dropColumn('promo_margin_percent');
            }
            if (Schema::hasColumn('business_calculations', 'promo_percent')) {
                $table->dropColumn('promo_percent');
            }
            if (Schema::hasColumn('business_calculations', 'tax_percent')) {
                $table->dropColumn('tax_percent');
            }
            if (Schema::hasColumn('business_calculations', 'overhead_percent')) {
                $table->dropColumn('overhead_percent');
            }
            if (Schema::hasColumn('business_calculations', 'admin_fee_percent')) {
                $table->dropColumn('admin_fee_percent');
            }
        });
    }
};
