<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','index')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/change-password', [ProfileController::class, 'chnagePassword'])->name('password.update');
    Route::resource('user', UserController::class);
    Route::resource('alumni', AlumniController::class);
    Route::get('/assign-alumni', [AlumniController::class, 'assignAlumni'])->name('assign.alumni');
    Route::get('/get-alumni', [AlumniController::class, 'alumniList'])->name('assign.list');
});








require __DIR__.'/auth.php';
