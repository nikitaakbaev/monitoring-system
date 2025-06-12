<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\ActiveAccount;
use App\Http\Middleware\Admin;

Route::middleware(Admin::class)->group(function () {
    Route::get('/createUser', function () {
        return view('createUser');
    })->name('createUser');
    Route::post('/createUserAccount', [UserController::class, 'createUserAccount'])->name('createUserAccount');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.delete');
        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
        Route::post('/roles/{user}', [AdminController::class, 'updateUserRole'])->name('roles.update');
        Route::get('/schedules', [AdminController::class, 'schedules'])->name('schedules');
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
        Route::post('/notifications', [AdminController::class, 'updateNotifications'])->name('notifications.update');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });
});

Route::middleware('guest')->group( function () {
    Route::get('/auth', function () {
        return view('auth');
    }) -> name('login');
    Route::post('/userAuth', [UserController::class, 'authUser']) -> name('authUser');
});

Route::middleware('auth')->group( function () {
    Route::get('/', function () {
        return view('home');
    }) -> name('home');
    Route::get('/profileUser', function () {
        return view('profileUser');
    }) -> name('profileUser');
    Route::middleware(ActiveAccount::class)->group(function () {
        Route::get('/passChange', function () {
            return view('passChange');
        })->name('passChange');
        Route::post('/userPassChange', [UserController::class, 'userPassChange'])->name('userPassChange');
    });
    Route::get('/logout', [UserController::class, 'logout']) -> name('logout');
});
