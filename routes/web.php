<?php

use App\Http\Controllers\ProfileController;
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
            return redirect()->route('admin.dashboard');
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
});

Route::prefix('teacher')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
    Route::get('/attendance', function () {
        return view('teacher.attendance');
    })->name('teacher.attendance');

});

Route::prefix('student')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('student.index');
    })->name('student.index');



});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
