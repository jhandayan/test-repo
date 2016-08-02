<?php

namespace App\Http\Controllers;

use Acme\Helper\ControllerHelper;
use Acme\Repositories\PermissionRepository;
use Acme\Repositories\RoleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Gate;
use Auth;

/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{
    use ControllerHelper;

    protected $role;
    protected $permissions;

    private $message;

    /**
     * RoleController constructor.
     * @param RoleInterface $role
     * @param PermissionInterface $permissions
     */
    public function __construct(RoleRepository $role, PermissionRepository  $permissions){
        $this->middleware('auth');
    	$this->role         = $role;
        $this->permissions  = $permissions;
        $this->role->setListener($this);
    }

    public function setMessage($message){
        $this->message = $message;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request){
        if(Gate::denies('view_roles'))
        {
            return view('Acme.errors.403');
	    }
	    else
	    {
            $data['search']     = trim($request->input('search'));
            $data['sort']       = ($request->input('sort') == 'asc')? 'desc' : 'asc';
            $data['page_number']= $request->input('page');
            $data['role'] = $this->role->getRole($request);
            return view('Acme.role.index',$data);
	    }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){

        if(Gate::denies('add_role')){
            abort(403);
        }
    	$data['action']         = route('role_store');
    	$data['header']         = 'Add Role';
    	$data['role']           = $this->role->create();
        $data['permissions']    = $this->permissions->getPermissionToRole();
    	return view('Acme.role.form',$data);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){

    	return $this->role->save($request);
//            if($result['message'] == false){
//                return redirect()->route('role_add')->withErrors($result['results'])->withInput();
//            }
//        return redirect()->route('role_add')->with('message', 'Successfully Added');
    
    }

    /**
     * @param $id
     */
    public function edit($id){

        if(Gate::denies('update_role')){
            abort(403);
        }
    	$data['action']             = route('role_update',$id);
    	$data['header']             = 'Edit Role';
    	$role                       = $this->role->find($id);
        $permission_role            = [];
        foreach($role->permission as $permission){
            $permission_role[]  = $permission->id;
        }
        $data['permission_role']    = $permission_role;
        $data['role']               = $role;
        $data['permissions']        = $this->permissions->getPermissionToRole();
        return view('Acme.role.form',$data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){

    	return $this->role->save($request,$id);

    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if(Gate::denies('delete_role')){
            abort(403);
        }

        $result     = $this->role->delete($id);
        if($result){
            return redirect()->route('role_list')->with('message', 'Successfully Deleted');
        }
    }

}
