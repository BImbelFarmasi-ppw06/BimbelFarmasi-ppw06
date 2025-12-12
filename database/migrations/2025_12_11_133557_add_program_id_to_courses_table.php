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
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('program_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('file_path')->nullable()->after('video_url');
            $table->string('file_name')->nullable()->after('file_path');
            $table->integer('file_size')->nullable()->after('file_name');
            $table->enum('type', ['material', 'assignment'])->default('material')->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn(['program_id', 'file_path', 'file_name', 'file_size', 'type']);
        });
    }
};
