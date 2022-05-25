<?php

namespace App\Http\Controllers;

use App\Models\TrueOrFalse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TrueOrFalseController extends Controller
{

    public function index()
    {
        $true_or_falses = DB::table('true_or_falses')->select('id','difficulty', 'question_text','grade','CorrectAnswer')->get();
        if(is_null($true_or_falses) || !$true_or_falses->count()){
            return response()->json('No Questions Found', 404);
        }

        return response()->json($true_or_falses, 200);
    }
    public function store(Request $request)
    {
        $question_trueOrfalse=new TrueOrFalse();
        $question_trueOrfalse->chapters_id=$request->chapters_id;
        $question_trueOrfalse->difficulty=$request->difficulty;
        $question_trueOrfalse->question_text=$request->question_text;
        $question_trueOrfalse->CorrectAnswer=$request->CorrectAnswer;
        $question_trueOrfalse->grade=$request->grade;
        if($question_trueOrfalse->save()) {
            return ['status'=>'data inserted'];
        }
    }


    public function getByID($prof_code,$subject_id,$chapter_id,$question_id){
        $mcqs =  DB::table('true_or_falses')
        ->select('true_or_falses.id','difficulty','question_text','grade','CorrectAnswer')
        ->where('id', $question_id)->first();
        if(is_null($mcqs)){
            return response()->json('true_or_falses not Found', 404);
        }
        return response()->json($mcqs, 200);
    }

    public function update(Request $request,$prof_code,$subject_id, $chapter_id ,$question_id){
        $validator = Validator::make($request->all(), [
            'question_text' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the Question', 400);
        }

        $question= TrueOrFalse::find($question_id);
        if(is_null($question)){
            return response()->json('question not Found', 404);
        }
        $question->difficulty = $request->difficulty;
        $question->question_text = $request->question_text;
        $question->CorrectAnswer = $request->CorrectAnswer;
        $question->grade=$request->grade;


        if($question->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the question', 400);
    }

    public function destroy($prof_code,$subject_id,$chapter_id,$mcq_id)
    {
        $true_or_falses= TrueOrFalse::find($mcq_id);
        if(is_null($true_or_falses)){
            return response()->json('Question not Found', 404);
        }
        $true_or_falses->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
