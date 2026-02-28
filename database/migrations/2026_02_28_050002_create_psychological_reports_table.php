<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psychological_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_session_id')->unique()->constrained('test_sessions')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size')->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychological_reports');
    }
};
