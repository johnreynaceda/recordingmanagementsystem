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
        if (! Schema::hasColumn('sections', 'academic_year_id')) {
            return;
        }

        $foreignKey = $this->foreignKeyName('sections', 'academic_year_id');

        Schema::table('sections', function (Blueprint $table) use ($foreignKey) {
            if ($foreignKey) {
                $table->dropForeign($foreignKey);
            }

            $table->dropColumn('academic_year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sections', 'academic_year_id')) {
            return;
        }

        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('academic_year_id')->nullable()->after('staff_id');
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
