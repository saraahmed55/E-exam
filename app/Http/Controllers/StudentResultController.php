<?php

namespace App\Http\Controllers;

use App\Models\Student_result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentResultController extends Controller
{
   public function getAvgResults(){
       $avg = DB::table('student_results')->selectRaw('exams_id, avg(result) as avg_result')->groupBy('exams_id')->get();
       if(!is_null($avg) && $avg->count()){
        $subjectsavg = collect();
        foreach($avg as $average){
            $subject = DB::table('exams')->leftJoin('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->select('subjects.name')->where('exams.id', $average->exams_id)->first();
            $avgobject = [
                'subject'=> $subject->name,
                'exams_id' => $average->exams_id,
                'average_result' => $average->avg_result
            ];
            $subjectsavg->push($avgobject);
           }
           return response()->json($subjectsavg, 200);
       }
       return response()->json('results not found', 404);
   }

   public function getAllresultsOfExam($exam_id){

    $results=DB::table('student_results')->join('students', 'students.id', '=', 'student_results.student_id')
    ->select('students.id','students.student_code','students.first_name','students.last_name','result')
    ->where('exams_id',$exam_id)->get();

    if(is_null($results)){
        return response()->json('Results Not Found', 404);
    }

    return response()->json($results, 200);
   }

   public function destroy($result_id){
        $result= Student_result::find($result_id);
        if(is_null($result)){
            return response()->json('Result not Found', 404);
        }
        $result->delete();
        return response()->json('Deleted Successfully', 200);
    }

    public function AvrgResults(){
        $avg = DB::table('student_results')
        ->selectRaw('exams_id,avg(result) as avg_result')->groupBy('exams_id')->get();
        if(is_null($avg)){
            return response()->json('Average not Found', 404);
        }
        return response()->json($avg,200);
    }







}
