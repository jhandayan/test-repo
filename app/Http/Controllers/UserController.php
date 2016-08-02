<?php

namespace App\Http\Controllers;

use Acme\Helper\ControllerHelper;
use Acme\Repositories\UserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Gate;

//use App\Http\Controllers\Controller;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
	use ControllerHelper;
	protected $user;
	protected $auth;
	private $message;

	/**
	 * UserController constructor.
	 * @param UserInterface $user
	 */
	public function __construct(UserRepository $user){
		$this->middleware('auth');
		$this->user = $user;
		$this->auth = Auth::user();
		$this->user->setListener($this);
	}

	/**
	 * @param $message
	 */
	public function setMessage($message){
		$this->message = $message;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request){
		if(Gate::denies('add_user')){
			return view('Acme.errors.403');
		}

		$data['search']	= trim($request->input('search'));
		$data['sort']   = ($request->input('sort') == 'asc')? 'desc' : 'asc';
		$data['page_number']= $request->input('page');
		$data['users'] 	= $this->user->getUsers($request);
		return view('Acme.user.index',$data);
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(){
		if(Gate::denies('add_user')){
			return view('Acme.errors.403');
		}

		$data = $this->user->create();

		return view('Acme.user.form', $data);
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function save(Request $request, $id = 0){
		return $this->user->save($request, $id);
	}


	/**
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id){
		if(Gate::allows('update_user') || Auth::user()->id == $id){
			$data = $this->user->edit($id);
			return view('Acme.user.form', $data);
		}else{
			return view('Acme.errors.403');
		}

	}


	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id){
		$input = $request->except(['__token']);
		return $this->user->update($input, $id);
		return "update done";
	}
	/**

	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id){
		if(Gate::denies('delete_user')){
			return view('Acme.errors.403');
		}

		$this->user->destroy($id);

		return redirect()->route('users')->with('status','User successfully deleted!');
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function assign_role(Request $request, $id){
		$this->user->assign_role($request->role, $id);

		return redirect()->route('users')->with('status','User successfully assigned a role!');
	}

	public function show($id = 0){
		if($id != 0){
			$data['user'] = $this->user->show($id);
			return view('Acme.user.show',$data);
		}

		$data['user'] = $this->user->show($this->auth->id);

		return view('Acme.user.show',$data);
	}

	public function profile(){

	}

}
