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
        // Add fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('profile_photo');
            $table->string('program_studi')->nullable()->after('pekerjaan');
            $table->string('angkatan')->nullable()->after('program_studi');
        });

        // Add link_video field to testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('link_video')->nullable()->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'program_studi', 'angkatan']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('link_video');
        });
    }
};
