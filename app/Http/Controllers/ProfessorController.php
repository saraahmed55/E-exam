<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProfessorController extends Controller
{


    public function getProfessorInfo($prof_code) {
        $info = DB::table('professors')
        ->select('prof_code', 'first_name', 'last_name', 'email',)
        ->where('prof_code', $prof_code)->first();

        if(is_null($info)){
            return response()->json('No Information Found', 404);
        }

        return response()->json($info, 200);
    }


    public function getProfessorSubjects($prof_code){

        $prof_id=DB::table('professors')->select('id')->where('prof_code',$prof_code)->first();

        if( is_null($prof_id)){
            return response()->json('No Subjects Found', 404);
        }

        $subjects = DB::table('level_subjects')->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->select('subjects.id', 'subjects.name')->where('professor_id',$prof_id->id)->get();

        if(is_null($subjects) || !$subjects->count()){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }


    public function getProfessorSubjectExams($prof_code, $subjectid){

        date_default_timezone_set('Africa/Cairo');
        $exams = DB::table('exams')->select('id as exam_id', 'start_time', 'end_time', 'duration_minutes')->where('subject_id', $subjectid)->get();

        if(is_null($exams)){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function showprofessorCreateExamForm(){

        return response()->json( 'create exam',200);
    }


   public function getStudentsOfSubjects($prof_code,$subjectid){

        $prof_id=DB::table('professors')->select('id')->where('prof_code',$prof_code)->first();

        if( is_null($prof_id)){
            return response()->json('No Subjects Found', 404);
        }

        $students = DB::table('level_subjects')->join('students', 'students.level', '=', 'level_subjects.level')
        ->select('students.student_code')->where('subject_id',$subjectid)->where('professor_id',$prof_id->id)->get();

        if(is_null($students) || !$students->count()){
            return response()->json('No Students Found', 404);
        }

        return response()->json($students, 200);
    }


    // $department_id = DB::table('level_subjects')->select('department_id')->where('subject_id', $subjectid)->get();

    // if(is_null($department_id)){
    //     return response()->json('department Not Found', 404);
    // }


    // //  $students=DB::table('students')->select('id', 'student_code','first_name')->where('department_id',$department_id->department_id)->get();

    // // $students = DB::table('level_subjects')->join('students', 'students.department_id', '=', 'level_subjects.department_id')
    // // ->select( 'students.student_code')->where('department_id',$department_id->department_id)->get();

    // // if(is_null($students)){
    // //     return response()->json('No Results Found', 404);
    // // }

    // return response()->json($department_id, 200);


   public function getStudentSubjectResults($prof_code,$studentcode, $subjectid){

    $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

    if(is_null($studentid)){
        return response()->json('Student Not Found', 404);
    }

    $results = DB::table('student_results')->join('exams', 'exams.id', '=', 'student_results.exams_id')
    ->select('exams.id as exam_id', 'result')->where('student_id', $studentid->id)->where('subject_id', $subjectid)->get();

    if(is_null($results) || !$results->count()){
        return response()->json('No Results Found', 404);
    }

    return response()->json($results, 200);
}

}
