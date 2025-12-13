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
        Schema::table('programs', function (Blueprint $table) {
            // Add tutor field
            if (!Schema::hasColumn('programs', 'tutor')) {
                $table->string('tutor')->nullable()->after('description');
            }
            
            // Add schedule field
            if (!Schema::hasColumn('programs', 'schedule')) {
                $table->string('schedule')->nullable()->after('tutor');
            }
            
            // Add duration as string (e.g., "3 bulan", "6 minggu")
            if (!Schema::hasColumn('programs', 'duration')) {
                $table->string('duration')->nullable()->after('schedule');
            }
            
            // Add status field
            if (!Schema::hasColumn('programs', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['tutor', 'schedule', 'duration', 'status']);
        });
    }
};
