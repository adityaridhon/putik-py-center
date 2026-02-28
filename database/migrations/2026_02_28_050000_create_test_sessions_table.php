<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->foreignId('test_token_id')->nullable()->unique()->constrained('test_tokens')->onDelete('set null');
            $table->enum('test_type', ['intelligence', 'learning_style', 'interest', 'all'])->default('all');
            $table->enum('status', ['in_progress', 'completed', 'pending_analysis', 'reported'])->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('completion_time_minutes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_sessions');
    }
};
