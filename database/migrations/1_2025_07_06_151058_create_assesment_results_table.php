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
        Schema::create('assesment_results', function (Blueprint $table) {
            $table->id();
            $table->integer('depression_score');
            $table->string('depression_level', 50);
            $table->integer('anxiety_score');
            $table->string('anxiety_level', 50);
            $table->integer('stress_score');
            $table->string('stress_level', 50);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesment');
    }
};