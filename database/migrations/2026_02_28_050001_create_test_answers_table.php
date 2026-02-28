<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_session_id')->constrained('test_sessions')->onDelete('cascade');
            $table->enum('test_type', ['intelligence', 'learning_style', 'interest']);
            $table->string('category_name')->nullable(); // Verbal, Numerik, A, B, C, dll
            $table->string('question_type'); // intelligence_question, learning_statement, interest_job
            $table->unsignedBigInteger('question_id');
            $table->text('answer_value');
            $table->timestamps();
            
            $table->index(['test_session_id', 'test_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_answers');
    }
};
