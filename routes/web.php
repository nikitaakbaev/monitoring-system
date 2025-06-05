<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ActiveAccount;
use App\Http\Middleware\Admin;

Route::middleware(Admin::class)->group( function () {
    Route::get('/createUser', function () {
        return view('createUser');
    }) -> name('createUser');
    Route::post('/createUserAccount', [UserController::class, 'createUserAccount']) -> name('createUserAccount');
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
