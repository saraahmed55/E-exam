<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/login/student',[LoginController::class,'showstudentLoginForm']);
Route::get('/login/professor', [LoginController::class,'showprofessorLoginForm']);
Route::get('/register/student', [RegisterController::class,'showstudentRegisterForm']);
Route::get('/register/professor', [RegisterController::class,'showprofessorRegisterForm']);


Route::post('/login/student', [LoginController::class,'StudentLogin']);
Route::post('/login/professor', [LoginController::class,'ProfessorLogin']);
Route::post('/register/student', [RegisterController::class,'createStudent']);
Route::post('/register/professor', [RegisterController::class,'createProfessor']);



Route::group(['middleware' => 'auth:student'], function () {
    Route::view('/student', 'student');
});

Route::group(['middleware' => 'auth:professor'], function () {

    Route::view('/professor', 'professor');
});

Route::get('logout', [LoginController::class,'logout']);
