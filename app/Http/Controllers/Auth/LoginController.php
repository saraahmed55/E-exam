<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;
use SebastianBergmann\Environment\Console;

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
            return response()->json( 'login Student',200);
            // redirect()->intended('/student');
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
           return response()->json( 'login proffesor',200);
        }
        return back()->withInput($request->only('email','remember'));


    }
}
