<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('section_id');
        });

        Schema::table('attendance_records', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('student_record_id');
        });

        Schema::table('term_grades', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('section_id');
        });

        Schema::table('student_grades', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('file_path');
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });

        Schema::table('attendance_records', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });

        Schema::table('term_grades', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });

        Schema::table('student_grades', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });
    }
};
