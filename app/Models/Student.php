<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function gradeLevel(){
        return $this->belongsTo(GradeLevel::class);
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function studentRecords(){
        return $this->hasMany(StudentRecord::class);
    }
}
