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
            ->select('name')->where('exams.id', $average->exams_id)->first();
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

}
