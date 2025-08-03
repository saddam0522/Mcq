<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Auth')->group(function () {
    Route::middleware('guest:employer')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('/logout', 'logout')->middleware('auth:employer')->withoutMiddleware('guest:employer')->name('logout');
        });

        Route::controller('RegisterController')->group(function () {
            Route::get('/register', 'showRegistrationForm')->name('register');
            Route::post('/register', 'register');
        });
    });
});

Route::middleware('auth:employer')->controller('DashboardController')->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});