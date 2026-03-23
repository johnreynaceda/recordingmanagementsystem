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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('birthdate');
            $table->string('address');
            $table->string('contact_number')->nullable();
            $table->string('lrn')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', [
                'active',
                'graduated',
                'transfer in',
                'transfer out',
                'dropped',
                'LOA',
                'inactive'
            ])->default('active');
            $table->string('academic_year')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('section')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
