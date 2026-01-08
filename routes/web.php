<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Student\MyGrade;
use App\Livewire\Auth\ForgotPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/dashboard', function () {
    switch (auth()->user()->user_type) {
        case 'admin':
            return redirect()->route('admin.staffs');
        case 'teacher':
            return redirect()->route('teacher.dashboard');

        case 'student':
                return redirect()->route('student.index');

        default:
            # code...
            break;
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('administrator')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/staffs', function () {
        return view('admin.staffs');
    })->name('admin.staffs');
    Route::get('/grade-level', function () {
        return view('admin.grade-level');
    })->name('admin.grade-level');
    Route::get('/grade-level/subjects/{id}', function () {
        return view('admin.grade-level-subjects');
    })->name('admin.grade-level-subjects');
    Route::get('/section/{id}', function () {
        return view('admin.section');
    })->name('admin.section');
    Route::get('/students', function () {
        return view('admin.students');
    })->name('admin.students');

    Route::get('/students/create', function () {
        return view('admin.students-create');
    })->name('admin.students-create');

        Route::get('/students/{id}', function () {
            return view('admin.students-record');
        })->name('admin.students-record');

        Route::get('/request', function () {
            return view('admin.request');
        })->name('admin.request');

        Route::get('/calendar', function () {
            return view('admin.calendar');
        })->name('admin.calendar');
});

Route::prefix('teacher')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
    Route::get('/attendance', function () {
        return view('teacher.attendance');
    })->name('teacher.attendance');
    Route::get('/attendance/records', function () {
        return view('teacher.view-records');
    })->name('teacher.view-records');
    Route::get('/grading', function () {
        return view('teacher.grading');
    })->name('teacher.grading');
    Route::get('/calendar', function () {
        return view('teacher.calendar');
    })->name('teacher.calendar');

});

Route::prefix('student')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('student.index');
    })->name('student.index');

    Route::get('/request', function () {
        return view('student.request');
    })->name('student.request');
    Route::get('/calendar', function () {
        return view('student.calendar');
    })->name('student.calendar');
    Route::get('/grade', MyGrade::class)->name('student.grade');



});

Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
