<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExamsController extends Controller
{

    public function createExam(Request $request){

        $exam=new Exams();
        $exam->subject_id=$request->subject_id;
        $exam->start_time=$request->start_time;
        $exam->end_time=$request->end_time;
        $exam->duration_minutes=$request->duration_minutes;
        $exam->mcq_easy_questionsNumber=$request->mcq_easy_questionsNumber;
        $exam->mcq_medium_questionsNumber=$request->mcq_medium_questionsNumber;
        $exam->mcq_hard_questionsNumber=$request->mcq_hard_questionsNumber;
        $exam->tf_easy_questionsNumber=$request->tf_easy_questionsNumber;
        $exam->tf_medium_questionsNumber=$request->tf_medium_questionsNumber;
        $exam->tf_hard_questionsNumber=$request->tf_hard_questionsNumber;
        if($exam->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function index(){

        $exams = DB::table('exams')->join('subjects', 'subjects.id', '=', 'exams.subject_id')
        ->select('exams.id as exam_id','exams.name as name', 'subjects.name as subject', 'start_time', 'end_time', 'duration_minutes')->get();
        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamsBySubject($subject_id){

        $exams = DB::table('exams')->join('subjects', 'subjects.id', '=', 'exams.subject_id')
        ->select('exams.id as exam_id','name', 'start_time', 'end_time', 'duration_minutes')
        ->where('exams.subject_id', $subject_id)->get();
        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamsInformationBySubject($prof_code,$subject_id,$exam_id){

        $exams = DB::table('exams')->join('subjects', 'subjects.id', '=', 'exams.subject_id')
        ->select('mcq_easy_questionsNumber', 'mcq_medium_questionsNumber', 'mcq_hard_questionsNumber', 'tf_easy_questionsNumber', 'tf_medium_questionsNumber', 'tf_hard_questionsNumber')
        ->where('exams.id', $exam_id)->get();
        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamsInformation($prof_code,$exam_id){

        $exams=DB::table('exams')->select('start_time','end_time','duration_minutes','mcq_easy_questionsNumber', 'mcq_medium_questionsNumber', 'mcq_hard_questionsNumber', 'tf_easy_questionsNumber', 'tf_medium_questionsNumber', 'tf_hard_questionsNumber')
        ->where('exams.id',$exam_id)->get();

        if(is_null($exams)|| !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }
}
