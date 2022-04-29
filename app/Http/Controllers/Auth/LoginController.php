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
            $student =  DB::table('students')
            ->select('id', 'student_code','email')
            ->where('email', $request->email)->first();
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
            $professor =  DB::table('professors')->join('roles', 'roles.id', '=', 'professors.roles_id')
            ->select('professors.id', 'prof_code','email', 'roles.name as role_name')
            ->where('email', $request->email)->first();
            if(is_null($professor)){
                return response()->json('Professor not Found', 404);
            }
            return response()->json($professor, 200);
        //    return response()->json( 'login proffesor',200);
        }
        return back()->withInput($request->only('email','remember'));


    }
}
