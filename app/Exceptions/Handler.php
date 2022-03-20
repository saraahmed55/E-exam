<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

     protected function unauthenticated($request, AuthenticationException $exception)
     {
        if($request->is('student')|| $request->is('admin/*'))
        {
            return redirect()->guest('/login/student');
        }
        if($request->is('professor')|| $request->is('professor/*'))
        {
            return redirect()->guest('/login/professor');
        }
        return redirect()->guest(route('login'));
     }
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
