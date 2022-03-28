<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exams;
use App\Models\Student_result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function getStudentSubjects($studentcode){
        $level = DB::table('students')->select('level')->where('student_code', $studentcode)->first();

        $department = DB::table('students')->select('department_id')->where('student_code', $studentcode)->first();

        if(is_null($level) || is_null($department)){
            return response()->json('No Subjects Found', 404);
        }

        $subjects = DB::table('level_subjects')->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->select('subjects.id', 'subjects.name')->where('level', $level->level)->where('department_id', $department->department_id)->get();

        if(is_null($subjects) || !$subjects->count()){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }

    public function getStudentInfo($studentcode) {
        $info = DB::table('students')->join('departments', 'departments.id', '=', 'students.department_id')
        ->select('student_code', 'first_name', 'last_name', 'email', 'level','departments.name as department_name',)
        ->where('student_code', $studentcode)->first();

        if(is_null($info)){
            return response()->json('No Information Found', 404);
        }

        return response()->json($info, 200);
    }

    public function getStudentSubjectResults($studentcode, $subjectid){
        $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        if(is_null($studentid)){
            return response()->json('Student Not Found', 404);
        }

        $results = DB::table('student_results')->join('exams', 'exams.id', '=', 'student_results.exams_id')
        ->select('exams.id as exam_id', 'result')->where('student_id', $studentid->id)->where('subject_id', $subjectid)->get();

        if(is_null($results) || !$results->count()){
            return response()->json('No Results Found', 404);
        }

        return response()->json($results, 200);
    }

    public function getStudentSubjectExams($studentcode, $subjectid){
        date_default_timezone_set('Africa/Cairo');
        $exams = DB::table('exams')->select('id as exam_id', 'start_time', 'end_time', 'duration_minutes')->where('subject_id', $subjectid)
        ->where('end_time', '>=', now())->get();

        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamQuestions($studentcode, $examid){

    }

    public function PostExam(Request $request){
        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'exams_id' => 'required',
            'result'=> 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json('Can not save the result', 400);
        }
        $student_id = DB::table('students')->select('id')->where('id', $request->student_id)->first();

        if(is_null($student_id)){
            return response()->json('Student Not Found', 404);
        }
        $exam_id = DB::table('exams')->select('id')->where('id', $request->exams_id)->first();

        if(is_null($exam_id)){
            return response()->json('Exam Not Found', 404);
        }

        $previous_results = DB::table('student_results')->select('student_id', 'exams_id','result')
        ->where('exams_id', $request->exams_id)->where('student_id', $request->student_id)->get();
        if(!is_null($previous_results) && $previous_results->count()){
            return response()->json('Student have previous results in this exam', 400);
        }

        $result = DB::table('student_results')->upsert([
            'student_id' => $request->student_id,
            'exams_id' => $request->exams_id,
            'result' => $request->result
        ], ['student_id', 'exams_id'], ['result']);
        if($result == 0){
            return response()->json('Can not save the result', 500);
        }
        return response()->json('Saved Successfully', 200);
    }
}
