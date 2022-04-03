<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use Illuminate\Http\Request;

class McqController extends Controller
{

    public function store(Request $request)
    {
        $question_mcq=new Mcq();
        $question_mcq->chapters_id=$request->chapters_id;
        $question_mcq->difficulty=$request->difficulty;
        $question_mcq->question_text=$request->question_text;
        $question_mcq->answer1=$request->answer1;
        $question_mcq->answer2=$request->answer2;
        $question_mcq->answer3=$request->answer3;
        $question_mcq->answer4=$request->answer4;
        $question_mcq->CorrectAnswer=$request->CorrectAnswer;
        if($question_mcq->save()) {
            return ['status'=>'data inserted'];
        }
    }
    
}
