<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function gradeLevel(){
        return $this->belongsTo(GradeLevel::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function attendanceRecords(){
        return $this->hasMany(AttendanceRecord::class);
    }
}
