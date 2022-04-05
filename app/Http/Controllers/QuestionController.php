<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $question=new Question();
        $question->chapters_id=$request->chapters_id;
        $question->question_types_id=$request->question_types_id;
        $question->question_difficulty_id=$request->question_difficulty_id;
        $question->question_text=$request->question_text;
        if($question->save()) {
            return ['status'=>'data inserted'];
        }
    }
}
