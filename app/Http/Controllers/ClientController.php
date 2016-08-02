<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Acme\Repositories\UserRepository;
use Auth;
use Gate;

class ClientController extends Controller
{
    protected $user;
    protected $auth;
    //
    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');
        $this->auth = Auth::user();
        $this->user = $user;
    }

    public function index(Request $request){
        if(Gate::denies('view_clients')){
            return view('Acme.errors.403');
        }

        $data['search']	        = trim($request->input('search'));
        $data['sort']           = ($request->input('sort') == 'asc')? 'desc' : 'asc';
        $data['page_number']    = $request->input('page');
        $data['users']          = $this->user->getClients($request);
        return view('Acme.clients.index',$data);
    }

    public function profile($id){

        if(Gate::denies('view_client_profile')){
            return view('Acme.errors.403');
        }

        $user               = $this->user->find($id);
        $details            = [];
        foreach($user->usermeta as $meta):
            if($meta->option == 'account_details'):
                $details    = unserialize($meta->value);
                if($details['specified_number_children'] != ''){
                    $details['number_children'] = $details['specified_number_children'];
                }
                unset($details['specified_number_children']);
                unset($details['_token']);
                unset($details['step']);
            endif;
        endforeach;

        $data['metas']  = $details;
        $data['user']   = $user;
        return view('Acme.clients.profile',$data);
    }

    public function edit($id){
        if(Gate::denies('edit_client')){
            return view('Acme.errors.403');
        }
    }

    public function update(Request $request){

    }

    public function destroy($id){
        if(Gate::denies('delete_client')){
            return view('Acme.errors.403');
        }
    }
}
