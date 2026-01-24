<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        
        // --- RELASI (FOREIGN KEYS) ---
        // Menghubungkan ke tabel services
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        
        // Menghubungkan ke user (pemesan). Asumsi tabel users bawaan Laravel dipakai.
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        
        // Psikolog yang menangani (Bisa kosong/null saat awal booking)
        $table->unsignedBigInteger('psychologist_id')->nullable();
        
        // Admin yang mencatat (Bisa null)
        $table->integer('recorded_by')->nullable();

        // --- DATA FORMULIR ---
        $table->string('customer_name', 100);
        $table->string('customer_phone', 20)->nullable();
        $table->text('topic')->nullable(); // Keluhan/Topik
        
        // Pilihan Kategori (ENUM sesuai ERD)
        $table->enum('service_category', ['children_center', 'konseling_terapi', 'pemeriksaan_psikologi']);
        
        // Jenis Layanan (Personal / Klasikal)
        $table->enum('option_type', ['personal', 'klasikal']);
        
        // Nama Perusahaan (Diisi jika pilih Klasikal)
        $table->string('company_name', 150)->nullable();
        
        // --- JADWAL ---
        $table->date('booking_date');
        $table->time('booking_time');
        
        // Status & Notes
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->text('notes')->nullable();
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
