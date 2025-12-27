<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up() {
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
        $table->string('day');
        $table->string('time_slot');
$table->enum('status', ['pending', 'approved', 'rejected', 'expired', 'cancelled'])->default('pending');        
        // Buraya ekliyoruz, böylece çakışma ihtimali kalmıyor
        $table->boolean('is_read_student')->default(false);
        $table->boolean('is_read_teacher')->default(false);
        $table->timestamp('expires_at')->nullable();
        
        $table->text('message')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
