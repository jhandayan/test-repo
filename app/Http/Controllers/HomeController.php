<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Config;
use Acme\Helper\AesTrait;
use Acme\Repositories\UserRepository;
use Acme\Repositories\UserMetaRepository;

class HomeController extends Controller
{
    use AesTrait;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function index(){
        return view('frontend.home');
    }

    public function signup(){
        return view('auth.register');
    }

    public function signin(){
        if(Auth::user())
        {
            return redirect()->route('users');
        }
        // return view('frontend.signin');
        return view('auth.login');
    }



    /**
     * if signup passed this method will be call from repository class listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passed(){
       return redirect()->route('success')->with('status', 'Success');
     }

     /**
     * if signup failed, this method will be call from repository class listener
     * @param $validator
     * @return $this
     */
    public function failed($validator){
        return redirect()->route('signup', ['error'])->withErrors($validator)->withInput();
    }

    public function ajaxPassed(){
        return response()->json(['status' => 1, 'message' => $this->ajax_message]);
    }

    public function ajaxFail(){
        return response()->json(['status' => 0, 'message' => $this->ajax_message]);
    }

    public function ajaxResults(){
        return response()->json($this->ajax_results);
    }

    public function validateEmail(Request $request){
        return response()->json($this->user->checkEmail($request->email));
    }

    public function SignUpSuccess(){
        return view('frontend.welcome');
    }

    public function auth(Request $request)
    {
        $email      = trim($request->email);
        $password   = trim($request->password);
        $remember   = $request->remember;


        $checkemail = $this->user->checkEmail($email);
        if($checkemail['status'] == 1) return redirect()->back()->with('error', 'Your email does not exist!');


        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 'Active'], $remember))
        {
            return redirect()->route('dashboard');
//            if(Auth::user()->hasRole('administrator'))
//            {
//                return redirect()->route('dashboard');
//            }

//            return redirect()->route('home');
        }
        else
        {
//            redirect()->back()->withErrors();
            return redirect()->back()->withInput()->with('error', 'Invalid password!');
//            return redirect()->back()->withInput()->withFlashMessage('Wrong username/password combination.');
//            return redirect()->route('login')->with('errors', 'Invalid Username and Password.');
        }
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }
}

