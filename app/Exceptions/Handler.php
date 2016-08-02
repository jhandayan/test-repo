<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof TokenMismatchException){
            //Redirect to login form if session expires
//            return redirect($request->fullUrl())->with('errors',"The login form has expired, please try again. In the future, reload the login page if it has been open for several hours.");
            if($request->ajax()){
                $uri    = route('login');
                if(Route::getFacadeRoot()->current()->uri() == 'submitted'){
                    $uri    = route('signup');
                }
                return response()->json(['status' => 500, 'url' => $uri, 'message' => 'Token Mismatch']);
//                return response()->json(['status' => 500, 'url' => $request->fullUrl(), 'message' => 'Token Mismatch']);
            }

            return redirect($request->fullUrl());
        }

        if($e instanceof NotFoundHttpException)
        {
            return response()->view('Acme.errors.404', [], 404);
        }

        return parent::render($request, $e);
    }
}
