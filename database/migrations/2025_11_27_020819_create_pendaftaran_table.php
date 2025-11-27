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
        Schema::create('pendaftaran', function (Blueprint $table) {
        $table->id();
        
        // Data Pelanggan
        $table->string('nama_pelanggan');
        $table->string('nik_pelanggan')->nullable();
        $table->string('no_hp'); 
        $table->text('alamat_pemasangan');
        $table->string('koordinat')->nullable(); 

        // Relasi ke tabel paket_layanan
        $table->foreignId('id_paket')->constrained('paket_layanan')->onDelete('restrict');

        // Status Workflow
        $table->enum('status', [
            'Pending',
            'Verified',
            'Scheduled',
            'Progress',
            'Reported',
            'Completed'
        ])->default('Pending');

        // Relasi ke tabel users
        $table->foreignId('id_teknisi')->nullable()->constrained('users')->onDelete('set null');
        
        $table->dateTime('tanggal_jadwal')->nullable(); 
        $table->text('catatan_admin')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
