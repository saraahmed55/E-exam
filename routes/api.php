<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/students/{studentcode}/info', [StudentController::class,'getStudentInfo']);
Route::get('/students/{studentcode}/subjects', [StudentController::class,'getStudentSubjects']);
Route::get('/students/{studentcode}/subject/{subjectid}/results', [StudentController::class,'getStudentSubjectResults']);
Route::get('/students/{studentcode}/subject/{subjectid}/exams', [StudentController::class,'getStudentSubjectExams']);
