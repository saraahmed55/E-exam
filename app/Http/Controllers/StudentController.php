<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getStudentSubjects($studentcode){
        $level = DB::table('students')->select('level')->where('student_code', $studentcode)->first();

        $department = DB::table('students')->select('department_id')->where('student_code', $studentcode)->first();

        if(is_null($level) || is_null($department)){
            return response()->json('No Subjects Found', 404);
        }

        $subjects = DB::table('level_subjects')->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->select('subjects.id', 'subjects.name')->where('level', $level->level)->where('department_id', $department->department_id)->get();

        if(is_null($subjects)){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }

    public function getStudentInfo($studentcode) {
        $info = DB::table('students')->join('departments', 'departments.id', '=', 'students.department_id')
        ->select('student_code', 'first_name', 'last_name', 'email', 'level','departments.name as department_name',)
        ->where('student_code', $studentcode)->first();

        if(is_null($info)){
            return response()->json('No Information Found', 404);
        }

        return response()->json($info, 200);
    }

    public function getStudentSubjectResults($studentcode, $subjectid){
        $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        if(is_null($studentid)){
            return response()->json('No Results Found', 404);
        }

        $results = DB::table('student_results')->join('exams', 'exams.id', '=', 'student_results.exams_id')
        ->select('exams.id as exam_id', 'result')->where('student_id', $studentcode)->where('subject_id', $subjectid)->first();

        if(is_null($results)){
            return response()->json('No Results Found', 404);
        }

        return response()->json($results, 200);
    }

    public function getStudentSubjectExams($studentcode, $subjectid){
        $exams = DB::table('exams')->select('id as exam_id', 'time')->where('subject_id', $subjectid)->first();

        if(is_null($exams)){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamQuestions($studentcode, $examid){

    }

    public function PostExam(Request $request){

    }
}
