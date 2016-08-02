<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

class DashboardController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(Request $request){

        return view('Acme.dashboard');
    }




}
