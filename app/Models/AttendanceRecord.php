<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function studentRecord(){
        return $this->belongsTo(StudentRecord::class);
    }

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }
}
