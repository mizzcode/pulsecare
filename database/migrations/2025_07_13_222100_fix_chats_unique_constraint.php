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
    Schema::table('chats', function (Blueprint $table) {
      // Drop the existing unique constraint by name
      $table->dropUnique('chats_patient_id_doctor_id_status_unique');

      // Add index for better performance on queries
      $table->index(['patient_id', 'doctor_id', 'status']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('chats', function (Blueprint $table) {
      // Drop the index
      $table->dropIndex(['patient_id', 'doctor_id', 'status']);

      // Restore the original unique constraint with specific name
      $table->unique(['patient_id', 'doctor_id', 'status'], 'chats_patient_id_doctor_id_status_unique');
    });
  }
};
