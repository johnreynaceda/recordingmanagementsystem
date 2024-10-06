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
            
        
        default:
            # code...
            break;
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('administrator')->middleware(['auth', 'verified'])->group( function(){
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
