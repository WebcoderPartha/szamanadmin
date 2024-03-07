<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Authentication
Route::get('/', [LoginController::class, 'loginPage'])->name('admin.login');
Route::post('/login', [LoginController::class, 'loginAction'])->name('admin.login.action');
// Authentication

Route::prefix('admin')->middleware('admin')->group(function (){
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->name('admin.dashboard');
});



//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


