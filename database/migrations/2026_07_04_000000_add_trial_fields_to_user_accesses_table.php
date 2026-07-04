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
        Schema::table('user_accesses', function (Blueprint $table) {
            $table->boolean('is_trial')->default(false)->after('order_id');
            $table->timestamp('expires_at')->nullable()->after('is_trial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_accesses', function (Blueprint $table) {
            $table->dropColumn(['is_trial', 'expires_at']);
        });
    }
};
