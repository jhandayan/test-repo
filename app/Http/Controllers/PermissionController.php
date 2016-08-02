<?php

namespace App\Http\Controllers;

use Acme\Repositories\PermissionRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use Acme\Helper\ControllerHelper;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends Controller
{
    use ControllerHelper;
    protected $permission;

    protected $message;

    /**
     * PermissionController constructor.
     * @param PermissionInterface $permission
     */
     public function __construct(PermissionRepository $permission){
         $this->middleware('auth');
    	 $this->permission = $permission;
         $this->permission->setListener($this);
         $this->middleware('auth');
    }

    public function setMessage($message){
        $this->message = $message;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request){
    	if(Gate::denies('view_permissions'))
        {
            return view('Acme.errors.403');
	    }
	    else
	    {
            $data['search']     = trim($request->input('search'));
            $data['sort']       = ($request->input('sort') == 'asc')? 'desc' : 'asc';
            $data['page_number']= $request->input('page');
            $data['permission'] = $this->permission->getPermission($request);
            return view('Acme.permission.index',$data);
	    }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        if(Gate::denies('add_permission')){
            return view('Acme.errors.403');
        }

    	$data['action'] = route('permission_store');
    	$data['header'] = 'Add Permission';
    	$data['permission'] =$this->permission->create();
    	return view('Acme.permission.form',$data);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
    	return $this->permission->save($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        if(Gate::denies('update_permission')){
            return view('Acme.errors.403');
        }

    	$data['action'] = route('permission_update',$id);
    	$data['header'] = 'Edit Permission';
    	$data['permission'] = $this->permission->find($id);
    	return view('Acme.permission.form',$data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
    	return $this->permission->save($request,$id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Gate::denies('delete_permission')){
            return view('Acme.errors.403');
        }

        $result     = $this->permission->destroy($id);
        if($result){
            return redirect()->route('permission_list')->with('message', 'Successfully Deleted');
        }
    }

}
