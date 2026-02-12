<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intelligence_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('intelligence_test_categories')->onDelete('cascade');
            $table->text('question_text')->nullable();
            $table->string('question_image')->nullable();
            $table->json('question_data')->nullable(); // Untuk deret angka, dll
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->string('option_e')->nullable();
            $table->string('correct_answer'); // A/B/C/D/E
            $table->text('explanation')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intelligence_test_questions');
    }
};
