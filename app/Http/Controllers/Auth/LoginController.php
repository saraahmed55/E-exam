<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\DB;
use App\Models\Professor;
use App\Models\Student;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
        $this->middleware('guest:professor')->except('logout');
    }


    public function showstudentLoginForm()
    {
        return response()->json( 'login student',200);
    }

    public function StudentLogin(Request $request)
    {
        $this->validate($request,[

            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if(Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $std = Student::where('email', $request->email)->first();
            $token = auth()->guard('student')->user()->createToken($request->email)->plainTextToken;
            $student =  DB::table('students')
            ->select(['id', 'student_code','email', DB::raw("'$token' as token")])
            ->where('email', $request->email)->first();
            if(is_null($student)){
                return response()->json('Student not Found', 404);
            }
            return response()->json( $student,200);
        }
        return back()->withInput($request->only('email'));


    }

    public function showprofessorLoginForm()
    {
        return response()->json( 'login proffesor',200);
    }


    public function ProfessorLogin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if(Auth::guard('professor')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $prof = Professor::where('email', $request->email)->first();
            $token = auth()->guard('professor')->user()->createToken($request->email)->plainTextToken;
            $professor =  DB::table('professors')->join('roles', 'roles.id', '=', 'professors.roles_id')
<<<<<<< HEAD
            ->select(['professors.id', 'prof_code','email', 'roles.name as role_name', DB::raw("'$token' as token")])
=======
            ->select('professors.id','first_name', 'last_name','prof_code','email', 'roles.name as role_name')
>>>>>>> a993ecf5f7b2e0cbb07a806cb867772faedae3d1
            ->where('email', $request->email)->first();
            if(is_null($professor)){
                return response()->json('Professor not Found', 404);
            }
            return response()->json($professor, 200);

        }
        return back()->withInput($request->only('email','remember'));


    }
<<<<<<< HEAD

    // public function logout(Request $request)
    // {
    //     $user = Auth::user();
    //     $user->tokens()->delete();
    // }
=======
    public function logout(){
        Auth::logout();
    }
>>>>>>> a993ecf5f7b2e0cbb07a806cb867772faedae3d1
}
