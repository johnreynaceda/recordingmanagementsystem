<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('sections', 'academic_year_id')) {
            return;
        }

        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('staff_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('sections', 'academic_year_id')) {
            return;
        }

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('academic_year_id');
        });
    }
};
