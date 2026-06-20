<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->foreignId('last_year_attended_id')->nullable()->after('option')->constrained('academic_years')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->after('last_year_attended_id')->constrained('sections')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['last_year_attended_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn(['last_year_attended_id', 'section_id']);
        });
    }
};
