<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChaptersController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DepartmentsController;

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
Route::get('/students/{studentcode}/getexam/{examid}', [StudentController::class,'getExamQuestions']);
Route::post('/students/{studentcode}/saveresult', [StudentController::class,'PostExam']);


Route::get('/professors/{prof_code}/info', [ProfessorController::class,'getProfessorInfo']);
Route::get('/professors/{prof_code}/subjects', [ProfessorController::class,'getProfessorSubjects']);
Route::get('/professors/{prof_code}/subject/{subjectid}/exams', [ProfessorController::class,'getProfessorSubjectExams']);
Route::get('/professors/{prof_code}/subject/{subjectid}/exams/{examid}', [ProfessorController::class,'showprofessorCreateExamForm']);


Route::get('/professors/{prof_code}/subject/{subjectid}/students', [ProfessorController::class,'getStudentsOfSubjects']);
Route::get('/professors/{prof_code}/subject/{subjectid}/students/{studentcode}/results', [ProfessorController::class,'getStudentSubjectResults']);


Route::post('/professors/{prof_code}/subject/{subjectid}/createexam', [ExamsController::class,'createExam']);
Route::post('/professors/{prof_code}/subject/{subjectid}/createchapter', [ChaptersController::class,'store']);
Route::post('/professors/{prof_code}/subject/{subjectid}/createquestions', [QuestionController::class,'store']);
Route::post('/professors/{prof_code}/subject/{subjectid}/createsujects', [SubjectController::class,'store']);


Route::get('/admin/subjects', [SubjectController::class,'index']);
Route::get('/admin/subjects/{subject_id}', [SubjectController::class,'show']);
Route::post('/admin/addsubject', [SubjectController::class,'store']);
Route::put('/admin/editsubject/{subject_id}', [SubjectController::class,'update']);
Route::delete('/admin/deletesubject/{subject_id}', [SubjectController::class,'destroy']);

Route::get('/admin/departments', [DepartmentsController::class,'index']);
Route::post('/admin/adddepartment', [DepartmentsController::class,'store']);
Route::put('/admin/editdepartment/{department_id}', [DepartmentsController::class,'update']);
Route::delete('/admin/deletedepartment/{department_id}', [DepartmentsController::class,'destroy']);

Route::get('/admin/exams', [ExamsController::class,'index']);

Route::get('/admin/students', [StudentController::class,'index']);
Route::get('/admin/students/{student_id}', [StudentController::class,'show']);
Route::post('/admin/addstudent', [StudentController::class,'store']);
Route::put('/admin/editstudent/{student_id}', [StudentController::class,'update']);
Route::delete('/admin/deletestudent/{student_id}', [StudentController::class,'destroy']);

Route::get('/admin/professors', [ProfessorController::class,'index']);
Route::get('/admin/professors/{professor_id}', [ProfessorController::class,'show']);
Route::post('/admin/addprofessor', [ProfessorController::class,'store']);
Route::put('/admin/editprofessor/{professor_id}', [ProfessorController::class,'update']);
Route::delete('/admin/deleteprofessor/{professor_id}', [ProfessorController::class,'destroy']);

Route::get('logout', [LoginController::class,'logout']);
