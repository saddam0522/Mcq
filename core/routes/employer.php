<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Auth')->group(function () {
    Route::middleware('employer.guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('/logout', 'logout')->middleware('auth:employer')->withoutMiddleware('employer.guest')->name('logout');
        });

        Route::controller('RegisterController')->group(function () {
            Route::get('/register', 'showRegistrationForm')->name('register');
            Route::post('/register', 'register');
        });
    });
});

Route::middleware('auth:employer')->group(function () {
    Route::controller('DashboardController')->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller('ProfileController')->group(function () {
        Route::get('/change-password', 'changePasswordForm')->name('change.password');
        Route::post('/change-password', 'updatePassword');
        Route::get('/profile-setting', 'profileForm')->name('profile.setting');
        Route::post('/profile-setting', 'updateProfile');
    });

    Route::controller('Jobpost\JobController')->group(function () {
        Route::get('/jobs', 'index')->name('jobs.index');
        Route::post('/jobs/store', 'store')->name('jobs.store');
        Route::post('/jobs/update/{id}', 'update')->name('jobs.update');
        Route::post('/jobs/delete/{id}', 'destroy')->name('jobs.delete');
        Route::get('/job-categories', 'getJobCategories')->name('job.categories');
        Route::post('/jobs/update-status', 'updateStatus')->name('jobs.update.status');
    });
});