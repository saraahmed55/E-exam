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


   

}
