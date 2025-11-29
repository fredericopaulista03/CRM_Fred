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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('instagram')->nullable();
            $table->string('branch')->nullable();
            $table->string('revenue_raw')->nullable();
            $table->string('revenue_category')->nullable();
            $table->string('investment_raw')->nullable();
            $table->string('investment_category')->nullable();
            $table->string('objective')->nullable();
            $table->string('has_traffic')->nullable();
            $table->json('ai_tags')->nullable();
            $table->integer('score')->default(0);
            $table->string('urgency')->nullable();
            $table->string('kanban_status')->default('Frio'); // Frio, Morno, Quente, Ultra Quente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
