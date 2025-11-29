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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->string('field_name'); // Nome do campo no banco (ex: revenue_raw, investment_raw)
            $table->enum('input_type', ['text', 'select', 'radio', 'email', 'tel'])->default('text');
            $table->json('options')->nullable(); // Para select/radio: ["Opção 1", "Opção 2"]
            $table->string('placeholder')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
