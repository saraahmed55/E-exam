<?php

namespace App\Http\Controllers;

use App\Models\Level_subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LevelSubjectsController extends Controller
{

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'level' => 'required',
            'department_id'=> 'required',
            'subject_id'=>'required',
            'professor_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $level_Subjects = Level_subjects::create([
            'level' => $request->level,
            'department_id' => $request->department_id,
            'subject_id'=>$request->subject_id,
            'professor_id' => $request->professor_id,
        ]);
            return response()->json('Added Successfully', 200);
    }

    public function destroy($subject_id){

        $subject= Level_subjects::where ('subject_id', '=', $subject_id)->first();
        if(is_null($subject)){
            return response()->json('subject not Found', 404);
        }
        $subject->delete();
        return response()->json('Deleted Successfully', 200);
    }

}
