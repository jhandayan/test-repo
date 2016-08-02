<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Acme\Repositories\LogRepository;
use Acme\Repositories\UserRepository;

class LogController extends Controller
{
    //
    protected $log;
    protected $auth;
    protected $request;
    protected $user;
    private $message;



    public function __construct(LogRepository $log, UserRepository $user, Request $request)
    {
        $this->log      = $log;
        $this->user     = $user;
        $this->request  = $request;
        $this->log->setListener($this);
    }

    public function index(){
        $data['logs']   = $this->log->getLogs($this->request);

        $data['search']	= trim($this->request->input('search'));
        $data['sort']   = ($this->request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']= $this->request->input('page');
        return view('Acme.logs.logs', $data);
    }

    public function getUserLog($id){
        $data['user']   = $this->user->find($id);
        $data['logs']   = $this->log->getLogs($this->request, $id);
//        return view('Acme.errors.403');

        $data['search']	        = trim($this->request->input('search'));
        $data['sort']           = ($this->request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']    = $this->request->input('page');

        return view('Acme.logs.user', $data);
    }

    public function delete($id){

    }

    public function clearLog($id = 0){

    }
}
