<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

}
