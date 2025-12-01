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
        // Add indexes to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id', 'idx_orders_user_id');
            $table->index('status', 'idx_orders_status');
            $table->index('created_at', 'idx_orders_created_at');
            $table->index(['user_id', 'status'], 'idx_orders_user_status');
            $table->index(['status', 'created_at'], 'idx_orders_status_created');
        });

        // Add indexes to payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->index('order_id', 'idx_payments_order_id');
            $table->index('status', 'idx_payments_status');
            $table->index('created_at', 'idx_payments_created_at');
            $table->index(['status', 'created_at'], 'idx_payments_status_created');
        });

        // Add indexes to programs table
        Schema::table('programs', function (Blueprint $table) {
            $table->index('slug', 'idx_programs_slug');
            $table->index('is_active', 'idx_programs_is_active');
            $table->index(['is_active', 'type'], 'idx_programs_active_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user_id');
            $table->dropIndex('idx_orders_status');
            $table->dropIndex('idx_orders_created_at');
            $table->dropIndex('idx_orders_user_status');
            $table->dropIndex('idx_orders_status_created');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('idx_payments_order_id');
            $table->dropIndex('idx_payments_status');
            $table->dropIndex('idx_payments_created_at');
            $table->dropIndex('idx_payments_status_created');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex('idx_programs_slug');
            $table->dropIndex('idx_programs_is_active');
            $table->dropIndex('idx_programs_active_type');
        });
    }
};
