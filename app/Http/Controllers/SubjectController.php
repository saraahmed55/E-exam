<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{

    public function index(){
        $subjects = DB::table('subjects')->select('id', 'name')->get();
        if(is_null($subjects) || !$subjects->count()){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Add the Subject', 400);
        }
        $subject=new Subject();
        $subject->name=$request->name;
        if($subject->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function getByID($subject_id){
        $subject =  DB::table('subjects')
        ->select('subjects.id','name')
        ->where('id', $subject_id)->first();
        if(is_null($subject)){
            return response()->json('subject not Found', 404);
        }
        return response()->json($subject, 200);
    }

    public function getSubjectName($prof_code,$subject_id){

        $subject=DB::table('subjects')->select('name')->where('id',$subject_id)->get();
        if(is_null($subject)){
            return response()->json('No Subjects Found', 404);
        }
        return response()->json($subject, 200);
    }

    public function subjectInfoDepartment($prof_code,$subject_id){

        $dep=DB::table('level_subjects')->select('department_id')->where('subject_id',$subject_id)->first();
        if(is_null($dep)){
            return response()->json('Subject Not Found', 404);
        }
        $info = DB::table('level_subjects')->join('departments', 'departments.id', '=', 'level_subjects.department_id')
        ->select('departments.name')->where('subject_id',$subject_id)->get();

        if(is_null($info) || !$info->count()){
            return response()->json('No info Found', 404);
        }

        return response()->json($info, 200);
    }

    public function update(Request $request, $subject_id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the Subject', 400);
        }

        $subject= Subject::find($subject_id);
        if(is_null($subject)){
            return response()->json('Subject not Found', 404);
        }
        $subject->name = $request->name;
        if($subject->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Subject', 400);
    }

    public function destroy($subject_id){
        $subject= Subject::find($subject_id);
        if(is_null($subject)){
            return response()->json('Subject not Found', 404);
        }
        $subject->Delete();
        return response()->json('Deleted Successfully', 200);
    }
}
