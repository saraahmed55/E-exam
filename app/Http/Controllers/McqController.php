<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McqController extends Controller
{

    public function index()
    {
        $mcqs = DB::table('mcqs')->select('id','difficulty', 'question_text','answer1','answer2','answer3','answer4','CorrectAnswer')->get();
        if(is_null($mcqs) || !$mcqs->count()){
            return response()->json('No Questions Found', 404);
        }

        return response()->json($mcqs, 200);
    }

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
    public function destroy($mcq_id)
    {
        $mcq= Mcq::find($mcq_id);
        if(is_null($mcq)){
            return response()->json('Question not Found', 404);
        }
        $mcq->delete();
        return response()->json('Deleted Successfully', 200);
    }

}
