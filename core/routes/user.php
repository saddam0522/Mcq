<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function ()
{

    Route::middleware('guest')->group(function ()
    {
        Route::controller('LoginController')->group(function ()
        {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
        });

        Route::controller('RegisterController')->middleware(['guest'])->group(function ()
        {
            Route::get('register', 'showRegistrationForm')->name('register');
            Route::post('register', 'register');
            Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
        });

        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function ()
        {
            Route::get('reset', 'showLinkRequestForm')->name('request');
            Route::post('email', 'sendResetCodeEmail')->name('email');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function ()
        {
            Route::post('password/reset', 'reset')->name('password.update');
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
        });

        Route::controller('SocialiteController')->group(function ()
        {
            Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
            Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
        });
    });
});

Route::middleware('auth')->name('user.')->group(function ()
{

    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function ()
    {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function ()
    {

        Route::namespace('User')->group(function ()
        {

            Route::controller('UserController')->group(function ()
            {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');

                Route::post('apply-coupon', 'applyCoupon')->name('apply.coupon');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function ()
            {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });


            // Exam
            Route::controller('UserExamController')->group(function ()
            {
                Route::get('/exam/list', 'examList')->name('exam.list');
                Route::get('/participate/exam/{id}', 'perticipateExam')->name('exam.perticipate');

                Route::get('/participate', 'perticipate')->name('perticipate');

                Route::get('/attend/exam/{id}', 'takeExam')->name('take.exam');
                Route::post('/submission/script/', 'scriptSubmission')->name('exam.submission.script');
                Route::get('/show/result/{id}', 'result')->name('exam.result');

                Route::get('/exam/certificate/mcq/{id}', 'mcqCertificate')->name('exam.mcq.certificate');
                Route::get('/exam/certificate/written/{examid}', 'writtenCertificate')->name('exam.written.certificate');
                Route::get('/exam/mcq/history', 'mcqExamHistory')->name('exam.mcq.history');
                Route::get('/exam/written/history', 'writtenExamHistory')->name('exam.written.history');
                Route::get('/exam/written/details/{examid}', 'writtenExamDetails')->name('exam.written.details');
            });
        });

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function ()
        {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });

        Route::controller('Gateway\PaymentController')->group(function ()
        {
            Route::any('payment/{id?}', 'deposit')->name('payment');
            Route::get('preview/payment', 'depositPreview')->name('payment.preview');
            Route::get('payment/manual', 'manualDepositConfirm')->name('payment.manual.confirm');
            Route::post('payment/manual', 'manualDepositUpdate')->name('payment.manual.update');
        });
    });
});
