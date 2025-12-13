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
        Schema::table('quiz_banks', function (Blueprint $table) {
            // Add program_id for admin-created quizzes
            $table->foreignId('program_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            
            // Make order_id and user_id nullable (admin quizzes don't need them)
            $table->foreignId('order_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->change();
            
            // Add type to distinguish between practice and tryout
            $table->enum('type', ['practice', 'tryout'])->default('practice')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_banks', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn('program_id');
            $table->dropColumn('type');
            $table->foreignId('order_id')->nullable(false)->change();
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
