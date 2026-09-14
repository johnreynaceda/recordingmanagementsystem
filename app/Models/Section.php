<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function studentRecords(){
        return $this->hasMany(StudentRecord::class);
    }

    public function staff(){
        return $this->belongsTo(Staff::class);
    }

    public function gradeLevel(){
        return $this->belongsTo(GradeLevel::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function scopeForAcademicYear(Builder $query, $academicYearId): Builder
    {
        if (! filled($academicYearId)) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $query) use ($academicYearId) {
            $query->where('academic_year_id', $academicYearId)
                ->orWhereNull('academic_year_id');
        });
    }
}
