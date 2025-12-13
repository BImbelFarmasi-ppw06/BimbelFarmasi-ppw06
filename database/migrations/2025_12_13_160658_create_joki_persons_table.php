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
        Schema::create('joki_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama penjoki
            $table->string('expertise')->nullable(); // Keahlian (e.g., Farmakologi, Farmakoterapi)
            $table->string('wa_link'); // Link WhatsApp
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->string('photo')->nullable(); // Path foto penjoki
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joki_persons');
    }
};
