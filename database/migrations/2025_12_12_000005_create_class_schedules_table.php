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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Judul pertemuan
            $table->text('description')->nullable(); // Deskripsi pertemuan
            $table->date('date'); // Tanggal pertemuan
            $table->time('start_time'); // Jam mulai
            $table->time('end_time'); // Jam selesai
            $table->enum('type', ['online', 'offline'])->default('online'); // Tipe kelas
            $table->string('meeting_link')->nullable(); // Link Zoom/Google Meet
            $table->string('location')->nullable(); // Lokasi offline
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
