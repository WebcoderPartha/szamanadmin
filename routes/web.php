<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::prefix('admin')->middleware('admin')->group(function (){
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    });
});

Route::get('/', [LoginController::class, 'loginPage'])->name('admin.login');




//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


