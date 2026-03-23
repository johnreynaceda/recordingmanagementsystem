<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function studentRecords(): HasMany
    {
        return $this->hasMany(StudentRecord::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function termGrades(): HasMany
    {
        return $this->hasMany(TermGrade::class);
    }

    public function studentGrades(): HasMany
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(request::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getActiveYear()
    {
        return static::active()->first();
    }

    public function setAsActive(): void
    {
        static::where('is_active', true)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    public static function getActiveYearId(): ?int
    {
        return static::active()->value('id');
    }
}
