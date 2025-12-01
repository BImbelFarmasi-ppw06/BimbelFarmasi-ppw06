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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false)->after('is_admin');
            $table->timestamp('suspended_at')->nullable()->after('is_suspended');
            $table->unsignedBigInteger('suspended_by')->nullable()->after('suspended_at');
            $table->text('suspend_reason')->nullable()->after('suspended_by');
            $table->timestamp('last_login_at')->nullable()->after('suspend_reason');
            
            // Add foreign key for suspended_by
            $table->foreign('suspended_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['suspended_by']);
            $table->dropColumn([
                'is_suspended', 
                'suspended_at', 
                'suspended_by', 
                'suspend_reason',
                'last_login_at'
            ]);
        });
    }
};
