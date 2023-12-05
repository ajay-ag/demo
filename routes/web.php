<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'validtype:admin'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('category', CategoryController::class);
});

Route::middleware('auth', 'verified', 'validtype:user')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('question', QuestionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
