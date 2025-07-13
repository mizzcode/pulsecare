<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Check if the index exists before trying to drop it
    $indexExists = DB::select("SHOW INDEX FROM chats WHERE Key_name = 'chats_patient_id_doctor_id_status_unique'");
    
    Schema::table('chats', function (Blueprint $table) use ($indexExists) {
      // Drop the existing unique constraint if it exists
      if (!empty($indexExists)) {
        $table->dropUnique('chats_patient_id_doctor_id_status_unique');
      }

      // Check if regular index already exists
      $regularIndexExists = DB::select("SHOW INDEX FROM chats WHERE Key_name = 'chats_patient_id_doctor_id_status_index'");
      
      // Add index for better performance on queries (if not exists)
      if (empty($regularIndexExists)) {
        $table->index(['patient_id', 'doctor_id', 'status']);
      }
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
