<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        $this->hasMany(StudentRecord::class);
    }

    public function staff(){
        return $this->belongsTo(Staff::class);
    }

    public function gradeLevel(){
        return $this->belongsTo(GradeLevel::class);
    }
}
