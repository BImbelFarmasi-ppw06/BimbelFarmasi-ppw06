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
        Schema::table('quiz_attempts', function (Blueprint $table) {
            // Tambah kolom time_spent_seconds jika belum ada
            if (!Schema::hasColumn('quiz_attempts', 'time_spent_seconds')) {
                $table->integer('time_spent_seconds')->nullable()->after('completed_at');
            }
            
            // Tambah kolom answers jika belum ada
            if (!Schema::hasColumn('quiz_attempts', 'answers')) {
                $table->json('answers')->nullable()->after('is_passed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_attempts', 'time_spent_seconds')) {
                $table->dropColumn('time_spent_seconds');
            }
            
            if (Schema::hasColumn('quiz_attempts', 'answers')) {
                $table->dropColumn('answers');
            }
        });
    }
};
