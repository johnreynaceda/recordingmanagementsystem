<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('grade_level_subjects', 'academic_year_id')) {
            return;
        }

        $afterColumn = Schema::hasColumn('grade_level_subjects', 'teacher_id')
            ? 'teacher_id'
            : 'grade_level_id';

        Schema::table('grade_level_subjects', function (Blueprint $table) use ($afterColumn) {
            $table->foreignId('academic_year_id')->nullable()->after($afterColumn);
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('grade_level_subjects', 'academic_year_id')) {
            return;
        }

        $foreignKey = $this->foreignKeyName('grade_level_subjects', 'academic_year_id');

        Schema::table('grade_level_subjects', function (Blueprint $table) use ($foreignKey) {
            if ($foreignKey) {
                $table->dropForeign($foreignKey);
            }

            $table->dropColumn('academic_year_id');
        });
    }

    private function foreignKeyName(string $table, string $column): ?string
    {
        foreach (Schema::getForeignKeys($table) as $foreignKey) {
            if (($foreignKey['columns'] ?? []) === [$column]) {
                return $foreignKey['name'] ?? null;
            }
        }

        return null;
    }
};
