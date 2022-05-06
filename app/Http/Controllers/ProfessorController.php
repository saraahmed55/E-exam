<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ProfessorController extends Controller
{

    public function index(){
        $professors = DB::table('professors')
        ->select('id', 'prof_code', 'first_name', 'last_name','email')->get();
        if(is_null($professors) || !$professors->count()){
            return response()->json('No Professors Found', 404);
        }

        return response()->json($professors, 200);
    }

    public function getByID($professor_id){
        $professor =  DB::table('professors')
        ->select('professors.id', 'prof_code', 'first_name', 'last_name', 'roles_id', 'email','password')
        ->where('id', $professor_id)->first();
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        return response()->json($professor, 200);
    }



    public function showId($professor_id){
        $professor =  DB::table('professors')
        ->select('id')
        ->where('id', $professor_id)->first();
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        return response()->json($professor, 200);
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'=> 'required|string|max:255',
            'prof_code'=>'required|min:6|unique:professors',
            'email' => 'required|string|email|max:255|unique:professors',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $professor = Professor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'prof_code'=>$request->prof_code,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
            return response()->json('Added Successfully', 200);
    }


    public function update(Request $request, $professor_id){
        $validator = Validator::make($request->all(), [
            'prof_code'=> 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the professor', 400);
        }

        $professor= Professor::find($professor_id);
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        $professor->prof_code = $request->prof_code;
        $professor->first_name = $request->first_name;
        $professor->last_name = $request->last_name;
        $professor->email = $request->email;
        $professor->password = Hash::make($request->password);
        if($professor->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Professor', 400);
    }


    public function destroy($professor_id){

        $professor= Professor::find($professor_id);
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        $professor->delete();
        return response()->json('Deleted Successfully', 200);
    }


    public function getProfessorInfo($prof_code) {
        $info = DB::table('professors')
        ->select('prof_code', 'first_name', 'last_name', 'email',)
        ->where('prof_code', $prof_code)->first();

        if(is_null($info)){
            return response()->json('No Information Found', 404);
        }

        return response()->json($info, 200);
    }



    public function getProfessorcode($email) {

        $info = DB::table('professors')
        ->select('prof_code')
        ->where('email', $email)->first();

        if(is_null($info)){
            return response()->json('No Information Found', 404);
        }

        return response()->json($info, 200);
    }


    public function getProfessorSubjects($prof_code){

        $prof_id=DB::table('professors')->select('id')->where('prof_code',$prof_code)->first();

        if( is_null($prof_id)){
            return response()->json('No Subjects Found', 404);
        }

        $subjects = DB::table('level_subjects')->join('subjects', 'subjects.id', '=', 'level_subjects.subject_id')
        ->select('subjects.id', 'subjects.name')->where('professor_id',$prof_id->id)->get();

        if(is_null($subjects) || !$subjects->count()){
            return response()->json('No Subjects Found', 404);
        }

        return response()->json($subjects, 200);
    }


    public function getProfessorSubjectExams($prof_code, $subjectid){

        date_default_timezone_set('Africa/Cairo');
        $exams = DB::table('exams')->select('id as exam_id', 'start_time', 'end_time', 'duration_minutes')->where('subject_id', $subjectid)->get();

        if(is_null($exams)){
            return response()->json('No Exams Found', 404);
        }

        return response()->json($exams, 200);
    }

    public function showprofessorCreateExamForm(){

        return response()->json( 'create exam',200);
    }

    public function getProfessorSubjectChapters($prof_code, $subjectid){

        $chapters = DB::table('chapters')->select('id as chapter_id', 'chapter_number', 'chapter_name')->where('subject_id', $subjectid)->get();

        if(is_null($chapters)){
            return response()->json('No Chapters Found', 404);
        }

        return response()->json($chapters, 200);
    }

   public function getStudentsOfSubjects($prof_code,$subjectid){

        $prof_id=DB::table('professors')->select('id')->where('prof_code',$prof_code)->first();

        if( is_null($prof_id)){
            return response()->json('No Subjects Found', 404);
        }

        $students = DB::table('level_subjects')->join('students', 'students.level', '=', 'level_subjects.level')
        ->select('students.id','students.student_code','students.first_name','students.last_name')->where('subject_id',$subjectid)->where('professor_id',$prof_id->id)->get();

        if(is_null($students) || !$students->count()){
            return response()->json('No Students Found', 404);
        }

        return response()->json($students, 200);
    }


   public function getStudentSubjectResults($prof_code,$studentcode, $subjectid){

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

    public function getAdminProfessors(){
        $admins = DB::table('professors')->select('id', 'first_name', 'last_name')->where('roles_id', 1)->get();

        if(is_null($admins) || !$admins->count()){
            return response()->json('No Admins Found', 404);
        }

        return response()->json($admins, 200);
    }

    public function getProfessorProfessors(){
        $professors = DB::table('professors')->select('id', 'first_name', 'last_name')->where('roles_id', 2)->get();

        if(is_null($professors) || !$professors->count()){
            return response()->json('No Professors Found', 404);
        }

        return response()->json($professors, 200);
    }

    public function changeToAdmin($id){
        $professor= Professor::find($id);
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        $professor->roles_id = 1;
        if($professor->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Professor Role', 400);
    }

    public function changeToProfessor($id){
        $professor= Professor::find($id);
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        $professor->roles_id = 2;
        if($professor->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Professor Role', 400);
    }

}
