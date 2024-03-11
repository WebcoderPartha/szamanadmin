<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\PermissionController;

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

    // Role Route
    Route::resource('roles', RoleController::class);
    // User Route
    Route::resource('users', UserController::class);
    // User Delete
    Route::post('/user/del', [UserController::class, 'delete'])->name('admin.user.del');

    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'Profile'])->name('admin.profile');

    // Permission
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('admin.permission.create');

});



//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


