<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function studentRecords(){
        return $this->hasMany(StudentRecord::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }
}
