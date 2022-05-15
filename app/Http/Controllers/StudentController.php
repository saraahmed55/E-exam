<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exams;
use App\Models\Chapters;
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

    public function getByID($student_id){
        $student =  DB::table('students')
        ->select('students.id', 'student_code', 'first_name', 'last_name', 'level','department_id', 'email','password')
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
            'student_code'=>'required|min:6|unique:students',
            'level'=>'required',
            'department_id'=>'required',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $email = DB::table('students')->
        select('email')->where('email', $request->email)->first();

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

        $student= Student::find($student_id);

        if(is_null($student)){
            return response()->json('Student not Found', 404);
        }

        $student->student_code = $request->student_code;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->level = $request->level;
        $student->department_id = $request->department_id?? '';
        $student->password = Hash::make($request->password);

        if($student->save()) {
            return response()->json('Updated Successfully', 200);
        }

        return response()->json('Can not Edit the student last', 400);
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
        ->select('subjects.id as id', 'subjects.name as name')
        ->where('level', $level->level)
        ->where('department_id', $department->department_id)->get();

        if(is_null($subjects) || !$subjects->count()){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }

    public function getSubjectDetails($subjectid){
        $subject = DB::table('level_subjects')
        ->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->join('professors', 'professors.id', '=', 'level_subjects.professor_id')
        ->select('subjects.id as id', 'subjects.name as name', 'professors.first_name as prof_first_name', 'professors.last_name as prof_last_name')
        ->where('level_subjects.subject_id', $subjectid)->first();

        if(is_null($subject)){
            return response()->json('Subject Not Found', 404);
        }

        return response()->json($subject, 200);
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
        ->select('exams.id as exam_id', 'exams.name as exam_name', 'result')->where('student_id', $studentid->id)
        ->where('subject_id', $subjectid)->get();

        if(is_null($results) || !$results->count()){
            return response()->json('No Results Found', 404);
        }

        return response()->json($results, 200);
    }

    public function getStudentResults($studentcode){
        $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        if(is_null($studentid)){
            return response()->json('Student Not Found', 404);
        }

        $results = DB::table('exams')->join('student_results', 'exams.id', '=', 'student_results.exams_id')
        ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
        ->select('exams_id', 'exams.name as exams_name', 'subjects.name as subject', 'result')
        ->where('student_id', $studentid->id)->get();

        if(is_null($results) || !$results->count()){
            return response()->json('No Results Found', 404);
        }

        return response()->json($results, 200);
    }

    public function getStudentSubjectExams($studentcode, $subjectid){
        $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        if(is_null($studentid)){
            return response()->json('Student Not Found', 404);
        }

        date_default_timezone_set('Africa/Cairo');

        $exams = DB::table('exams')->join('subjects', 'exams.subject_id', '=', 'subjects.id')
        ->select('exams.id as exam_id', 'exams.name as exam_name', 'subjects.name as subject', 'start_time', 'end_time', 'duration_minutes')
        ->where('subject_id', $subjectid)->where('end_time', '>=', now())
        ->whereNotIn('exams.id', Student_result::select('exams_id')->where('student_id', $studentid->id))->get();

        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getStudentExams($studentcode){
        $studentid = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        date_default_timezone_set('Africa/Cairo');

        $level = DB::table('students')->select('level')->where('student_code', $studentcode)->first();

        $department = DB::table('students')->select('department_id')->where('student_code', $studentcode)->first();

        if(is_null($level) || is_null($department)){
            return response()->json('No Exams Found', 404);
        }

        $exams = DB::table('level_subjects')->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->join('exams', 'subjects.id', '=', 'exams.subject_id')
        ->select('exams.id as exam_id', 'exams.name as exam_name','subjects.name as subject', 'start_time', 'end_time', 'duration_minutes')
        ->where('level', $level->level)->where('department_id', $department->department_id)
        ->where('end_time', '>=', now())
        ->whereNotIn('exams.id', Student_result::select('exams_id')->where('student_id', $studentid->id))->get();

        if(is_null($exams) || !$exams->count()){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function getExamInfo($studentcode, $examid){

        $exam = DB::table('exams')->join('subjects', 'exams.subject_id', '=', 'subjects.id')
        ->select('exams.id as exam_id', 'exams.name as exam_name', 'subjects.name as subject', 'start_time', 'end_time', 'duration_minutes')
        ->where('exams.id', $examid)->first();

        if(is_null($exam)){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exam, 200);
    }

    public function getExamQuestions($studentcode, $examid){
        $subject_id = DB::table('exams')
        ->select('subject_id')
        ->where('exams.id', $examid)->first();
        $numberofquestions = DB::table('exams')
        ->select('exams.id', 'mcq_easy_questionsNumber', 'mcq_medium_questionsNumber', 'mcq_hard_questionsNumber', 'tf_easy_questionsNumber', 'tf_medium_questionsNumber', 'tf_hard_questionsNumber')
        ->where('exams.id', $examid)->first();

        if(!is_null($numberofquestions)){
            $questions = collect();
            $easymcq=$this->getExamMcqsByDifficulty('easy', $numberofquestions->mcq_easy_questionsNumber, $subject_id->subject_id);
            $questions->push($easymcq);
            $mediummcq=$this->getExamMcqsByDifficulty('medium', $numberofquestions->mcq_medium_questionsNumber, $subject_id->subject_id);
            $questions->push($mediummcq);
            $hardmcq=$this->getExamMcqsByDifficulty('hard', $numberofquestions->mcq_hard_questionsNumber, $subject_id->subject_id);
            $questions->push($hardmcq);

            $easytf=$this->getExamTorFByDifficulty('easy', $numberofquestions->tf_easy_questionsNumber, $subject_id->subject_id);
            $questions->push($easytf);
            $mediumtf=$this->getExamTorFByDifficulty('medium', $numberofquestions->tf_medium_questionsNumber, $subject_id->subject_id);
            $questions->push($mediumtf);
            $hardtf=$this->getExamTorFByDifficulty('hard', $numberofquestions->tf_hard_questionsNumber, $subject_id->subject_id);
            $questions->push($hardtf);

            return response()->json($questions->collapse(), 200);
        }
        return response()->json('Exam Questions Not Found', 404);
    }

    public function PostExam($studentcode, Request $request){
        $validator = Validator::make($request->all(), [
            'exams_id' => 'required',
            'result'=> 'required|numeric'
        ]);


        if($validator->fails()){
            return response()->json('Can not save the result', 400);
        }
        $student_id = DB::table('students')->select('id')->where('student_code', $studentcode)->first();

        if(is_null($student_id)){
            return response()->json('Student Not Found', 404);
        }
        $exam_id = DB::table('exams')->select('id')->where('id', $request->exams_id)->first();

        if(is_null($exam_id)){
            return response()->json('Exam Not Found', 404);
        }

        $previous_results = DB::table('student_results')->select('student_id', 'exams_id','result')
        ->where('exams_id', $request->exams_id)->where('student_id',$student_id->id)->get();
        if(!is_null($previous_results) && $previous_results->count()){
            return response()->json('Student have previous results in this exam', 400);
        }

        $result = DB::table('student_results')->upsert([
            'student_id' => $student_id->id,
            'exams_id' => $request->exams_id,
            'result' => $request->result
        ], ['student_id', 'exams_id'], ['result']);
        if($result == 0){
            return response()->json('Can not save the result', 500);
        }
        return response()->json('Saved Successfully', 200);
    }

    public function getExamMcqsByDifficulty($difficulty, $number_of_questions, $subject_id){
        $questionsfromdatabase = DB::table('mcqs')
        ->select(['id', 'chapters_id', 'difficulty', 'question_text', 'answer1', 'answer2', 'answer3', 'answer4', 'CorrectAnswer', DB::raw("'mcq' as type")])
        ->whereIn('chapters_id', Chapters::select('id')->where('subject_id', $subject_id))
        ->where('difficulty', $difficulty)
        ->inRandomOrder()
        ->limit($number_of_questions)
        ->get();
        return $questionsfromdatabase;
    }

    public function getExamTorFByDifficulty($difficulty, $number_of_questions, $subject_id){
        $questionsfromdatabase = DB::table('true_or_falses')
        ->select(['id', 'chapters_id', 'difficulty', 'question_text', DB::raw("'true' as answer1"),DB::raw("'false' as answer2"), 'CorrectAnswer',  DB::raw("'true or false' as type")])
        ->whereIn('chapters_id', Chapters::select('id')->where('subject_id', $subject_id))
        ->where('difficulty', $difficulty)
        ->inRandomOrder()
        ->limit($number_of_questions)
        ->get();
        return $questionsfromdatabase;
    }
}
