<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;

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


//    Route::get('/drop', [UserController::class, 'dropFile']);
    Route::post('/user/drop/store', [UserController::class, 'storeMedia'])->name('admin.store.media');
//    Route::post('/user/drop/post', [UserController::class, 'uploadStore'])->name('admin.upload.media');
//    Route::get('/drop/edit/{id}', [UserController::class, 'editDrop'])->name('admin.drop.edit');
//    Route::get('/drop/list', [UserController::class, 'dropIndex'])->name('admin.drop.list');
//    Route::put('/drop/update/{id}', [UserController::class, 'updateDropZone'])->name('admin.drop.update');

    // Profile Routes
    Route::get('/profile',[ProfileController::class, 'profileDetails'])->name('admin.profile');
    Route::get('/profile/edit',[ProfileController::class, 'profileEdit'])->name('admin.profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    // Profile Routes

    // Permission Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permission.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('admin.permission.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::put('/permissions/{id}/edit', [PermissionController::class, 'update'])->name('admin.permission.update');
    Route::post('/permissions/delete', [PermissionController::class, 'delete'])->name('admin.permission.delete');
    // Permission Routes

});



//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


