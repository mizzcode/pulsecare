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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); // User yang memulai chat
            $table->unsignedBigInteger('doctor_id');  // Dokter yang dipilih
            $table->string('status')->default('active'); // active, closed
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');

            // Satu user hanya bisa punya satu chat aktif dengan dokter tertentu
            // Tapi bisa punya banyak chat yang sudah ditutup (closed)
            $table->index(['patient_id', 'doctor_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
