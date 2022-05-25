<?php

namespace App\Http\Controllers;

use App\Models\Chapters;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaptersController extends Controller
{

    public function update(Request $request,$prof_code,$subject_id, $chapter_id){
        $validator = Validator::make($request->all(), [
            'chapter_name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the Chapter', 400);
        }

        $chapter= Chapters::find($chapter_id);
        if(is_null($chapter)){
            return response()->json('chapter not Found', 404);
        }
        $chapter->chapter_name = $request->chapter_name;
        if($chapter->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Chapter', 400);
    }

    public function getByID($prof_code,$subject_id,$chapter_id){
        $chapter =  DB::table('chapters')
        ->select('chapters.id','chapter_number','chapter_name')
        ->where('id', $chapter_id)->first();
        if(is_null($chapter)){
            return response()->json('chapter not Found', 404);
        }
        return response()->json($chapter, 200);
    }

    public function store(Request $request)
    {
        $chapter=new Chapters();
        $chapter->chapter_number=$request->chapter_number;
        $chapter->chapter_name=$request->chapter_name;
        $chapter->subject_id=$request->subject_id;
        if($chapter->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function destroy($prof_code,$subject_id,$chapters_id){
        $chapter =Chapters::find($chapters_id);
        if(is_null($chapter)){
            return response()->json('Chapter not Found', 404);
        }
        $chapter->Delete();
        return response()->json('Deleted Successfully', 200);
    }

    public function getChapterMCQ($prof_code,$subject_id,$chapters_id){
        $mcqs=DB::table('mcqs')->select('id as mcq_id','difficulty','question_text','answer1','answer2','answer3','answer4','grade','CorrectAnswer')
        ->where('chapters_id',$chapters_id)->get();

        if(is_null($mcqs) || !$mcqs->count()){
            return response()->json('No MCQs Found', 404);
        }

        return response()->json($mcqs, 200);
    }

    public function getChapterTorF($prof_code,$subject_id,$chapters_id){
        $TF=DB::table('true_or_falses')->select('id as tf_id','difficulty','question_text','grade','CorrectAnswer')
        ->where('chapters_id',$chapters_id)->get();

        if(is_null($TF) || !$TF->count()){
            return response()->json('No T or F Found', 404);
        }

        return response()->json($TF, 200);
    }

    public function getAllQuestions($prof_code,$subject_id,$chapters_id){
        $TF=DB::table('true_or_falses')->select('id as tf_id','difficulty','question_text','CorrectAnswer')
        ->where('chapters_id',$chapters_id)->get();

        if(is_null($TF) || !$TF->count()){
            return response()->json('No T or F Found', 404);
        }

        $mcqs=DB::table('mcqs')->select('id as mcq_id','difficulty','question_text','answer1','answer2','answer3','answer4','CorrectAnswer')
        ->where('chapters_id',$chapters_id)->get();

        if(is_null($mcqs) || !$mcqs->count()){
            return response()->json('No MCQs Found', 404);
        }

        return response()->json(array($TF,$mcqs));
    }
}
