<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function lastYearAttended(){
        return $this->belongsTo(AcademicYear::class, 'last_year_attended_id');
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }
}
