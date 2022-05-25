<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class McqController extends Controller
{

    public function index()
    {
        $mcqs = DB::table('mcqs')->select('id','difficulty', 'question_text','answer1','answer2','answer3','answer4','grade','CorrectAnswer')->get();
        if(is_null($mcqs) || !$mcqs->count()){
            return response()->json('No Questions Found', 404);
        }

        return response()->json($mcqs, 200);
    }

    public function store(Request $request,$prof_code,$subject_id,$chapter_id)
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
        $question_mcq->grade=$request->grade;
        if($question_mcq->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function getByID($prof_code,$subject_id,$chapter_id,$question_id){
        $mcqs =  DB::table('mcqs')
        ->select('mcqs.id','difficulty','question_text','answer1','answer2','answer3','answer4','grade','CorrectAnswer')
        ->where('id', $question_id)->first();
        if(is_null($mcqs)){
            return response()->json('mcqs not Found', 404);
        }
        return response()->json($mcqs, 200);
    }

    public function update(Request $request,$prof_code,$subject_id, $chapter_id ,$question_id){
        $validator = Validator::make($request->all(), [
            'question_text' => 'required',
            'answer1'=>'required',
            'answer2'=>'required',
            'answer3'=>'required',
            'answer4'=>'required',
            'grade'=>'required',

        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the Question', 400);
        }

        $question= Mcq::find($question_id);
        if(is_null($question)){
            return response()->json('question not Found', 404);
        }
        $question->difficulty = $request->difficulty;
        $question->question_text = $request->question_text;
        $question->answer1 = $request->answer1;
        $question->answer2 = $request->answer2;
        $question->answer3 = $request->answer3;
        $question->answer4 = $request->answer4;
        $question->CorrectAnswer = $request->CorrectAnswer;
        $question->grade=$request->grade;

        if($question->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the question', 400);
    }

    public function destroy($prof_code,$subject_id,$chapter_id,$mcq_id)
    {
        $mcq= Mcq::find($mcq_id);
        if(is_null($mcq)){
            return response()->json('Question not Found', 404);
        }
        $mcq->delete();
        return response()->json('Deleted Successfully', 200);
    }

}
