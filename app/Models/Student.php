<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Student $student): void {
            $studentRecordIds = DB::table('student_records')
                ->where('student_id', $student->id)
                ->pluck('id');

            DB::table('attendance_records')
                ->whereIn('student_record_id', $studentRecordIds)
                ->delete();
            DB::table('student_records')->where('student_id', $student->id)->delete();
            DB::table('student_grades')->where('student_id', $student->id)->delete();
            DB::table('term_grades')->where('student_id', $student->id)->delete();
            DB::table('notifications')->where('student_id', $student->id)->delete();

            static::deleteUserData($student->user_id);
        });
    }

    private static function deleteUserData(?int $userId): void
    {
        if (! $userId) {
            return;
        }

        $email = DB::table('users')->where('id', $userId)->value('email');

        DB::table('requests')->where('user_id', $userId)->delete();
        DB::table('sessions')->where('user_id', $userId)->delete();

        if ($email) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
        }

        DB::table('users')->where('id', $userId)->delete();
    }

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

    public function termGrades()
    {
        return $this->hasMany(TermGrade::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
}
