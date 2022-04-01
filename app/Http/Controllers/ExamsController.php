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
        if($exam->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function index(){

        $exams = DB::table('exams')->join('subjects', 'subjects.id', '=', 'exams.subject_id')
        ->select('exams.id as exam_id', 'subjects.name', 'start_time', 'end_time', 'duration_minutes')->get();
        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamsBySubject($subject_id){

        $exams = DB::table('exams')->join('subjects', 'subjects.id', '=', 'exams.subject_id')
        ->select('exams.id as exam_id', 'start_time', 'end_time', 'duration_minutes')
        ->where('exams.subject_id', $subject_id)->get();
        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }
}
