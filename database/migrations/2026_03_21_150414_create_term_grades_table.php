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
        Schema::create('term_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('section_id');
            $table->string('first_grading')->nullable();
            $table->string('second_grading')->nullable();
            $table->string('third_grading')->nullable();
            $table->string('fourth_grading')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_grades');
    }
};
