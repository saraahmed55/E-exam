<?php

namespace App\Http\Controllers;

use App\Models\TrueOrFalse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrueOrFalseController extends Controller
{

    public function index()
    {
        $true_or_falses = DB::table('true_or_falses')->select('id','difficulty', 'question_text','CorrectAnswer')->get();
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
        if($question_trueOrfalse->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function destroy($mcq_id)
    {
        $true_or_falses= TrueOrFalse::find($mcq_id);
        if(is_null($true_or_falses)){
            return response()->json('Question not Found', 404);
        }
        $true_or_falses->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
