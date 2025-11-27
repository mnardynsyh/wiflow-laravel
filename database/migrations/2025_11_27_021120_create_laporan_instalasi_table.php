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
        Schema::create('laporan_instalasi', function (Blueprint $table) {
        $table->id();
        
        // Relasi tabel pendaftaran
        $table->foreignId('id_pendaftaran')->constrained('pendaftaran')->onDelete('cascade');
        
        // Relasi tabel users
        $table->foreignId('id_teknisi')->constrained('users');
        
        $table->text('catatan_teknisi')->nullable();
        $table->string('bukti_foto'); 
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_instalasi');
    }
};
