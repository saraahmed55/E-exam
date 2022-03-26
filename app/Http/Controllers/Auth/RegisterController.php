<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    use RegistersUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:student');
        $this->middleware('guest:professor');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name'=> 'required|string|max:255',
            'student_code'=>'required|min:6',
            'level'=>'required',
            'department_id'=>'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function showstudentRegisterForm()
    {
        return response()->json( 'register student',200);
    }

    public function showprofessorRegisterForm()
    {

        return response()->json( 'register professor',200);
    }


    protected function createStudent(Request $request)
    {
        $this->validator($request->all())->validate();
        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'student_code'=>$request->student_code,
            'level'=>$request->level,
            'department_id'=>$request->department_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->intended('login/student');
    }

    protected function createProfessor(Request $request)
    {
        $this->validator($request->all())->validate();
        Professor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'prof_code'=>$request->prof_code,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json( 'created proffesor',200);
    }
}
