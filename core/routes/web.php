<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function ()
{
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});



// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function ()
{
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function ()
{
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');

    Route::get('page/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
    Route::get('exam/details/{id}', 'examDetails')->name('exam.details');


    Route::get('exams', 'exams')->name('exams');
    Route::get('/exams/{slug}', 'subjectExams')->name('subject.exams');

    Route::post('/subscribe', 'subscribe')->name('subscribe');
    Route::get('category/{slug}', 'categorySubject')->name('category.subjects');
    Route::get('/subjects', 'subjects')->name('subjects');

    Route::get('blog', 'blog')->name('blog');
    Route::get('/frequently-asked-question', 'faq')->name('faq');
});

Route::controller('JobController')->group(function ()
{
    Route::get('job/all', 'alljobs')->name('all.jobs');
    Route::get('job/details/{id}', 'jobDetails')->name('job.details');
});

Route::controller('Admin\Jobportal\JobCategoryController')->prefix('admin/job-categories')->name('admin.job.categories.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/store', 'store')->name('store');
    Route::post('/update/{id}', 'update')->name('update');
});