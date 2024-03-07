<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Authentication
Route::get('/', [LoginController::class, 'loginPage'])->name('admin.login');
Route::post('/login', [LoginController::class, 'loginAction'])->name('admin.login.action');
// Authentication

// Logout
Route::get('/logout', [LoginController::class, 'logOut'])->name('admin.logout');

Route::prefix('admin')->middleware('admin')->group(function (){


    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->name('admin.dashboard');

    // Role Routes
    Route::resource('roles', RoleController::class);
});



//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


