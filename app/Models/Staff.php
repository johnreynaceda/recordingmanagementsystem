<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Staff $staff): void {
            DB::table('sections')->where('staff_id', $staff->id)->update(['staff_id' => null]);
            DB::table('grade_level_subjects')->where('teacher_id', $staff->id)->update(['teacher_id' => null]);

            if (! $staff->user_id) {
                return;
            }

            $email = DB::table('users')->where('id', $staff->user_id)->value('email');

            DB::table('requests')->where('user_id', $staff->user_id)->delete();
            DB::table('sessions')->where('user_id', $staff->user_id)->delete();

            if ($email) {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }

            DB::table('users')->where('id', $staff->user_id)->delete();
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }
}
