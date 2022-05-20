<?php

use App\Http\Controllers\AdminRoleController;
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
use App\Http\Controllers\McqController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StudentResultController;
use App\Http\Controllers\TrueOrFalseController;
use App\Models\AdminRole;
use App\Models\Department;
use App\Models\Student_result;
use App\Models\TrueOrFalse;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:professor')->group(function () {

// });
// Route::middleware('auth:student')->group(function () {

// });

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/login/student',[LoginController::class,'showstudentLoginForm']);
Route::get('/login/professor', [LoginController::class,'showprofessorLoginForm']);
Route::get('/register/student', [RegisterController::class,'showstudentRegisterForm']);
Route::get('/register/professor', [RegisterController::class,'showprofessorRegisterForm']);


Route::post('/login/student', [LoginController::class,'StudentLogin']);
Route::post('/login/professor', [LoginController::class,'ProfessorLogin']);
Route::post('/logout/student', [LoginController::class,'StudentLogout']);
Route::post('/logout/professor', [LoginController::class,'logout']);
Route::post('/register/student', [RegisterController::class,'createStudent']);
Route::post('/register/professor', [RegisterController::class,'createProfessor']);


Route::get('/students/{studentcode}/info', [StudentController::class,'getStudentInfo']);
Route::get('/students/{studentcode}/subjects', [StudentController::class,'getStudentSubjects']);
Route::get('/students/subjects/{subjectid}', [StudentController::class,'getSubjectDetails']);
Route::get('/students/{studentcode}/subject/{subjectid}/results', [StudentController::class,'getStudentSubjectResults']);
Route::get('/students/{studentcode}/results', [StudentController::class,'getStudentResults']);
Route::get('/students/{studentcode}/subject/{subjectid}/exams', [StudentController::class,'getStudentSubjectExams']);
Route::get('/students/{studentcode}/exams', [StudentController::class,'getStudentExams']);
Route::get('/students/{studentcode}/getexaminfo/{examid}', [StudentController::class,'getExamInfo']);
Route::get('/students/{studentcode}/getexam/{examid}', [StudentController::class,'getExamQuestions']);
Route::post('/students/{studentcode}/saveresult', [StudentController::class,'PostExam']);


Route::get('/professors/{prof_code}/info', [ProfessorController::class,'getProfessorInfo']);
Route::get('/professors/{email}', [ProfessorController::class,'getProfessorcode']);
Route::get('/professors/{prof_code}/subjects', [ProfessorController::class,'getProfessorSubjects']);
Route::get('/professors/{prof_code}/subject/{subjectid}/exams', [ProfessorController::class,'getProfessorSubjectExams']);
Route::get('/professors/{prof_code}/subject/{subjectid}/exams/{examId}/information', [ExamsController::class,'getExamsInformationBySubject']);
Route::get('/professors/{prof_code}/exams', [ProfessorController::class,'getProfessorExams']);
Route::get('/professors/{prof_code}/exams/{examId}/information', [ExamsController::class,'getExamsInformation']);


Route::get('/professors/{prof_code}/subject/{subjectid}/chapters', [ProfessorController::class,'getProfessorSubjectChapters']);
Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}', [ChaptersController::class,'getByID']);
Route::put('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/edit', [ChaptersController::class,'update']);
Route::delete('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}', [ChaptersController::class,'destroy']);

Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapters_id}/mcqs', [ChaptersController::class,'getChapterMCQ']);
Route::post('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/createquestions/mcq', [McqController::class,'store']);
Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/mcqs/{question_id}', [McqController::class,'getByID']);
Route::put('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/mcqs/{question_id}/edit', [McqController::class,'update']);
Route::delete('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/mcqs/{mcq_id}', [McqController::class,'destroy']);

Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapters_id}/torf', [ChaptersController::class,'getChapterTorF']);
Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/allQuestions', [ChaptersController::class,'getAllQuestions']);
Route::post('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/createquestions/t&f', [TrueOrFalseController::class,'store']);
Route::get('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/torf/{question_id}', [TrueOrFalseController::class,'getByID']);
Route::put('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/torf/{question_id}/edit', [TrueOrFalseController::class,'update']);
Route::delete('/professors/{prof_code}/subject/{subjectid}/chapters/{chapter_id}/torf/{tf_id}', [TrueOrFalseController::class,'destroy']);

Route::get('/professors/{prof_code}/subject/{subjectid}/departmentName', [SubjectController::class,'subjectInfoDepartment']);
Route::get('/professors/{prof_code}/subject/{subjectid}', [SubjectController::class,'getSubjectName']);
Route::get('/professors/{prof_code}/subject/{subjectid}/studentCount', [ProfessorController::class,'getStudentCountInSubject']);

Route::get('/professors/{prof_code}/subject/{subjectid}/students', [ProfessorController::class,'getStudentsOfSubjects']);
Route::get('/professors/{prof_code}/subject/{subjectid}/students/{studentcode}/results', [ProfessorController::class,'getStudentSubjectResults']);
Route::get('/professors/{prof_code}/subject/{subjectid}/studentsResult', [ProfessorController::class,'getStudentResultsInExams']);

Route::post('/professors/{prof_code}/subject/{subjectid}/createexam', [ExamsController::class,'createExam']);
Route::post('/professors/{prof_code}/subject/{subjectid}/createchapter', [ChaptersController::class,'store']);
Route::post('/professors/{prof_code}/subject/{subjectid}/createsujects', [SubjectController::class,'store']);


Route::get('/admin/subjects', [SubjectController::class,'index']);
Route::get('/admin/subjects/{subject_id}', [SubjectController::class,'getByID']);
Route::post('/admin/addsubject', [SubjectController::class,'store']);
Route::put('/admin/editsubject/{subject_id}', [SubjectController::class,'update']);
Route::delete('/admin/deletesubject/{subject_id}', [SubjectController::class,'destroy']);

Route::get('/admin/questionsmcq', [McqController::class,'index']);
Route::post('/admin/addquestionsmcq', [McqController::class,'store']);
Route::delete('/admin/deletemcqquestion/{mcq_id}', [McqController::class,'destroy']);

Route::get('/admin/questionstorf', [TrueOrFalseController::class,'index']);
Route::post('/admin/addquestionstorf', [TrueOrFalseController::class,'store']);
Route::delete('/admin/deletetorfquestion/{mcq_id}', [TrueOrFalseController::class,'destroy']);

Route::get('/admin/departments', [DepartmentsController::class,'index']);
Route::post('/admin/adddepartment', [DepartmentsController::class,'store']);
Route::get('/admin/departments/{department_id}', [DepartmentsController::class,'getByID']);
Route::put('/admin/editdepartment/{department_id}', [DepartmentsController::class,'update']);
Route::delete('/admin/deletedepartment/{department_id}', [DepartmentsController::class,'destroy']);

Route::get('/admin/exams', [ExamsController::class,'index']);
Route::get('/admin/exams/{exam_id}/students_results', [StudentResultController::class,'getAllresultsOfExam']);
Route::delete('/admin/exams/{exam_id}/students_results/deleteResult/{student_result_id}', [StudentResultController::class,'destroy']);
Route::get('/admin/subjects/{subject_id}/exams', [ExamsController::class,'getExamsBySubject']);
Route::get('/admin/results', [StudentResultController::class,'getAvgResults']);

Route::get('/admin/user_roles', [AdminRoleController::class,'index']);
Route::get('/admin/user_roles/admins', [ProfessorController::class,'getAdminProfessors']);
Route::get('/admin/user_roles/professors', [ProfessorController::class,'getProfessorProfessors']);
Route::get('/admin/user_roles/toadmin/{id}', [ProfessorController::class,'changeToAdmin']);
Route::get('/admin/user_roles/toprofessor/{id}', [ProfessorController::class,'changeToProfessor']);
Route::get('/admin/user_roles/{role_id}', [AdminRoleController::class,'show']);
Route::get('/admin/user_roles/{role_id}/professors', [AdminRoleController::class,'getProfessorsOfRole']);
Route::get('/admin/getProfessorRole', [AdminRoleController::class,'getProfessorRole']);
Route::put('/admin/editprofessorrole/{professor_id}', [AdminRoleController::class,'update']);

Route::get('/admin/students', [StudentController::class,'index']);
Route::post('/admin/addstudent', [StudentController::class,'store']);
Route::get('/admin/students/{student_id}', [StudentController::class,'getByID']);
Route::put('/admin/editstudent/{student_id}', [StudentController::class,'update']);
Route::delete('/admin/deletestudent/{student_id}', [StudentController::class,'destroy']);


Route::get('/admin/professors', [ProfessorController::class,'index']);
Route::get('/admin/roles', [RolesController::class,'index']);
Route::get('/admin/professors/{professor_id}', [ProfessorController::class,'getByID']);
Route::post('/admin/addprofessor', [ProfessorController::class,'store']);
Route::put('/admin/editprofessor/{professor_id}', [ProfessorController::class,'update']);
Route::delete('/admin/deleteprofessor/{professor_id}', [ProfessorController::class,'destroy']);

Route::get('/logout', [LoginController::class,'logout']);
