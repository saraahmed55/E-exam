<?php

namespace App\Http\Controllers;

use App\Models\TrueOrFalse;
use Illuminate\Http\Request;

class TrueOrFalseController extends Controller
{
    public function store(Request $request)
    {
        $question_trueOrfalse=new TrueOrFalse();
        $question_trueOrfalse->chapters_id=$request->chapters_id;
        $question_trueOrfalse->difficulty=$request->difficulty;
        $question_trueOrfalse->question_text=$request->question_text;
        $question_trueOrfalse->CorrectAnswer=$request->CorrectAnswer;
        if($question_trueOrfalse->save()) {
            return ['status'=>'data inserted'];
        }
    }
}
