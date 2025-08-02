<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Employer')->middleware('employer.auth')->group(function ()
{

});