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
        Schema::create('class_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_level_id')->constrained('grade_levels');
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers');
            $table->string('section_name');
            $table->timestamps();
            $table->unique(['grade_level_id', 'academic_year_id', 'section_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sections');
    }
};
