<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exams;
use App\Models\Student_result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function index(){
        $students = DB::table('students')
        ->select('id', 'student_code', 'first_name', 'last_name', 'level','department_id','email')->get();
        if(is_null($students) || !$students->count()){
            return response()->json('No Students Found', 404);
        }

        return response()->json($students, 200);
    }

    public function show($student_id){
        $student =  DB::table('students')->
        select('id', 'student_code', 'first_name', 'last_name', 'level','department_id','email')
        ->where('id', $student_id)->first();
        if(is_null($student)){
            return response()->json('Student not Found', 404);
        }
        return response()->json($student, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'=> 'required|string|max:255',
            'student_code'=>'required|min:6',
            'level'=>'required',
            'department_id'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json('Can not Add the Student', 400);
        }
        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'student_code'=>$request->student_code,
            'level'=>$request->level,
            'department_id'=>$request->department_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
            return response()->json('Added Successfully', 200);
    }

    public function update(Request $request, $student_id){
        $validator = Validator::make($request->all(), [
            'student_code'=> 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email',
            'level' => 'required',
            'department_id' => 'required',
            'password'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the student', 400);
        }

        $student= Student::find($student_id);
        if(is_null($student)){
            return response()->json('Student not Found', 404);
        }
        $student->student_code = $request->student_code;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->level = $request->level;
        $student->department_id = $request->department_id;
        $student->password = Hash::make($request->password);
        if($student->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the student', 400);
    }

    public function destroy($student_id){
        $student= Student::find($student_id);
        if(is_null($student)){
            return response()->json('Student not Found', 404);
        }
        $student->delete();
        return response()->json('Deleted Successfully', 200);
    }

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
        ->select('student_code', 'first_name', 'last_name', 'email', 'level','departments.name as department_name')
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
        $numberofquestions = DB::table('exams__questions')
        ->select('exams_id', 'chapters_id', 'question_types_id', 'question_difficulty_id', 'Question_number')
        ->where('exams_id', $examid)->get();
        if(!is_null($numberofquestions) && $numberofquestions->count()){
            $questions = collect();
            foreach($numberofquestions as $value){
                $questionsfromdatabase = DB::table('questions')
                ->join('questions_answers', 'questions.id', '=', 'questions_answers.question_id')
                ->select('questions.id', 'question_types_id', 'question_difficulty_id', 'question_text', 'answer_text', 'isTrue')
                ->where('chapters_id', $value->chapters_id)
                ->where('question_types_id', $value->question_types_id)
                ->where('question_difficulty_id', $value->question_difficulty_id)
                ->inRandomOrder()
                ->limit($value->Question_number)
                ->get();
                $questions->push($questionsfromdatabase);
            }
            return response()->json($questions->collapse(), 200);
        }
        return response()->json('Exam Not Found', 404);
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
