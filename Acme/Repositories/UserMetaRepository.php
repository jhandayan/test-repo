<?php

namespace Acme\Repositories;
use Carbon\Carbon;
use Acme\Repositories\Repository;
use App\PersonalInfo;
use App\RoleUser;
use App\Role;
use Illuminate\Support\Facades\Validator;

class UserMetaRepository extends Repository{

    /*const LIMIT                 = 20;
    const INPUT_DATE_FORMAT     = 'Y-m-d';
    const OUTPUT_DATE_FORMAT    = 'F d,Y';*/

    protected $listener;

    public function model(){
        return 'App\UserMeta';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function setDate($date){
        return date('Y-m-d', strtotime($date));
    }

    public function getUsers($request){
        $query          = $this->model->leftJoin('personal_infos','personal_infos.user_id','=','users.id');
        if($request->has('search')){
            $search     = trim($request->input('search'));
            $query      = $query->where(function($query) use ($search){
                            $query->where('first_name','LIKE','%'.$search.'%')
                                ->orWhere('last_name','LIKE','%'.$search.'%')
                                ->orWhere('nickname','LIKE','%'.$search.'%')
                                ->orWhere('gender','LIKE','%'.$search.'%')
                                ->orWhere('position','LIKE','%'.$search.'%');
            });
        }

        $data           = $query->select('users.*')->get();

        return $data;
    }

    public function create(){

        $data['action']         = route('user_store');
        $data['action_name']    = 'Add';

        $data['email']          = old('email');
        $data['first_name']     = old('first_name');
        $data['last_name']      = old('last_name');
        $data['nickname']       = old('nickname');
        $data['status']         = old('status');
        $data['birthdate']      = old('birthdate');
        $data['gender']         = old('gender');
        $data['position']       = old('position');
        $data['date_hired']     = old('date_hired');

        return $data;
    }

    public function assign_role($request, $id){
        if(RoleUser::where('user_id',$id)->first()){
            RoleUser::where('user_id',$id)->update(['role_id' => $request]);
        }else{
            $this->model->where('id', $id)->first()->assignRole($request);
        }

    }

    public function save($request, $id = 0){

        $action     = ($id == 0) ? 'user_create' : 'user_edit';

        $input      = $request->all();

        $messages   = [
            'required' => 'The :attribute is required',
        ];
        $validator  = Validator::make($input, [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'nickname'      => 'required',
            'email'         => 'required',
            'birthdate'     => 'required',
            'gender'        => 'required',
            'position'      => 'required',
            'date_hired'    => 'required'
        ], $messages);

        if($validator->fails()){
            return $this->listener->failed($validator, $action);
        }

        if($id == 0){
            $this->model->create($input);
            $this->model->orderBy('created_at', 'desc')->first()->assignRole(2);
            $this->listener->setMessage('User is successfully created!');
        }else{
            $this->model->where('id',$id)->update($input);
            $this->listener->setMessage('User is successfully updated!');
        }

        return $this->listener->passed($action);
    }

    public function signupSave($id, $input)
    {
        $user_meta = [];
        $user_meta['user_id'] = $id;
        $unset_keys = ['first_name','last_name','email','password','phrase','confirm','state'];
        foreach($unset_keys as $key)
        {
            unset($input[$key]);
        };
        $user_meta['option']    = 'account_details';
        $user_meta['value']     = serialize($input);
        return $this->model->create($user_meta);
    }

    public function edit($id){
        $data['action']         = route('user_edit', $id);
        $data['action_name']    = 'Edit';

        $user                   = $this->model->find($id);
        $p_info                 = PersonalInfo::where('user_id', $id)->first();

        $data['email']          = (is_null(old('email'))?$user->email:old('email'));
        $data['first_name']     = (is_null(old('first_name'))?$user->first_name:old('first_name'));
        $data['last_name']      = (is_null(old('last_name'))?$user->last_name:old('last_name'));
        $data['nickname']       = (is_null(old('nickname'))?$user->nickname:old('nickname'));
        $data['status']         = (is_null(old('status'))?$user->status:old('status'));
        $data['password']       = (is_null(old('password'))?$user->password:old('password'));

        if(is_object($p_info)){
            $data['gender']     = (is_null(old('gender'))?$p_info->gender:old('gender'));
            $data['birthdate']  = $this->getDate((is_null(old('birthdate'))?$p_info->birthdate:old('birthdate')));
            $data['position']   = (is_null(old('position'))?$p_info->birthdate:old('position'));
            $datehired          = (is_null(old('date_hired'))?$p_info->date_hired:old('date_hired'));

            $data['date_hired'] = Carbon::createFromFormat(self::OUTPUT_DATE_FORMAT, $datehired);
        }else{
            $data['gender']     = old('gender');
            $data['birthdate']  = old('birthdate');
            $data['position']   = old('position');
            $data['date_hired'] = old('date_hired');
        }

        return $data;
    }

    public function show($id){
        $data = $this->model->find($id);

        return $data;
    }


    public function destroy($id){
        $this->model->where('id',$id)->delete();
        PersonalInfo::where('user_id',$id)->delete();
    }

    
    public function saveSignUp($request){

    }

}



