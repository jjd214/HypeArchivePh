<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;


Route::get('/', function () {
    return view('welcome');
});


// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['prevent-back-history'])->group(function () {
        Route::view('/login', 'admin.pages.auth.login')->name('login')->middleware('guest:admin');
        Route::post('/login_handler', [AdminController::class, 'loginHandler'])->name('login_handler')->middleware('guest:admin');
        Route::view('/forgot-password', 'admin.pages.auth.forgot-password')->name('forgot-password');
    });

    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        Route::view('/home', 'admin.pages.home')->name('home');
        Route::post('/logout_handler', [AdminController::class, 'logoutHandler'])->name('logout_handler');
        Route::get('/profile', [AdminController::class, 'profileView'])->name('profile');
        
    });
});

// Client routes
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/login', [ClientController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientController::class, 'login']);

    Route::middleware('auth:client')->group(function () {
        Route::get('/home', [ClientController::class, 'home'])->name('home');
    });
});

