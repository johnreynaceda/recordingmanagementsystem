<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function studentRecords()
    {
        return $this->hasMany(StudentRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function requests()
    {
        return $this->hasMany(request::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
}
