<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;



Route::get('/', function () {
    return view('welcome');
});



Route::group(['middleware' => 'auth:student'], function () {
    Route::view('/student', 'student');
});

Route::group(['middleware' => 'auth:professor'], function () {

    Route::view('/professor', 'professor');
});


