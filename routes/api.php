<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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


Route::get('/students/{studentcode}/info', [StudentController::class,'getStudentInfo']);
Route::get('/students/{studentcode}/subjects', [StudentController::class,'getStudentSubjects']);
Route::get('/students/{studentcode}/subject/{subjectid}/results', [StudentController::class,'getStudentSubjectResults']);
Route::get('/students/{studentcode}/subject/{subjectid}/exams', [StudentController::class,'getStudentSubjectExams']);


Route::get('/professors/{prof_code}/info', [ProfessorController::class,'getProfessorInfo']);
Route::get('/professors/{prof_code}/subjects', [ProfessorController::class,'getProfessorSubjects']);









Route::get('logout', [LoginController::class,'logout']);
