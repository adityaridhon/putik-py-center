<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intelligence_test_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // SE, WA, AN, dll
            $table->string('name');
            $table->enum('question_type', ['text', 'numeric', 'series', 'image', 'classification', 'memory']);
            $table->enum('answer_type', ['multiple_choice', 'text'])->default('multiple_choice');
            $table->integer('total_questions')->default(20);
            $table->integer('duration_minutes');
            $table->text('description')->nullable();
            $table->text('instruction')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intelligence_test_categories');
    }
};
