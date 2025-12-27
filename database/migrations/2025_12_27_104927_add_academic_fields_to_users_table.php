<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'faculty_id')) {
            $table->unsignedBigInteger('faculty_id')->nullable();
        }
        if (!Schema::hasColumn('users', 'department')) {
            $table->string('department')->nullable();
        }
        if (!Schema::hasColumn('users', 'class_level')) {
            $table->string('class_level')->nullable();
        }
        if (!Schema::hasColumn('users', 'language')) {
            $table->string('language')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
