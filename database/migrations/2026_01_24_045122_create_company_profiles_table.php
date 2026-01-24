<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('company_profiles', function (Blueprint $table) {
        $table->id();
        $table->string('company_name', 150);
        $table->text('headline')->nullable();       // Text besar di banner depan
        $table->text('about')->nullable();          // Konten "Tentang Putik"
        $table->string('logo', 255)->nullable();    // Path gambar logo
        $table->string('landing_image', 255)->nullable(); // Gambar banner utama
        
        // Kontak & Sosmed (Sesuai ERD & Footer UI)
        $table->string('phone', 20)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('instagram', 100)->nullable();
        $table->text('address')->nullable();

        $table->timestamps();
    });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
