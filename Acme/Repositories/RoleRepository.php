<?php
namespace Acme\Repositories;
use App\User;
use App\Role;
use Acme\Repositories\Repository;
use Illuminate\Support\Facades\Validator;

class RoleRepository extends Repository{
    const LIMIT = 10;

    protected $listener;

    public function model(){
        return 'App\Role';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function getRole($request){
        if($request->has('search')){
            return  $query = $this->model->where('name', 'LIKE', '%' . $request->input('search'). '%')
                                ->orWhere('label', 'LIKE', '%' . $request->input('search') . '%')
                                ->select('name','label')
                                ->orderBy('name', $request->input('sort'))
                                ->paginate(self::LIMIT);
        }
        if($request->input('order_by') && $request->input('sort')){
            return Role::orderBy($request->input('order_by'), $request->input('sort'))->paginate(self::LIMIT);
        }
        return Role::paginate(self::LIMIT);
    }

    public function create(){

        $data['name']     = old('name');
        $data['label']    = old('label');
        return $data;   
    }

    public function save($request, $id = 0){
        $action         = ($id == 0) ? 'role_add' : 'role_edit';
        $input          = $request->all();
        $messages       = ['required'      => 'The :attribute is required'];

        $validator      = Validator::make($input, ['name' => 'required', 'label' => 'required'], $messages);
        if ($validator->fails()) {$this->listener->failed($validator, $action);}

        if($id == 0){
            $role       = $this->model->create(['name' => $input['name'], 'label' => $input['label']]);
            if($role)
            {
                if(count($input['permission']) > 0){
                    $role->attachPermission($input['permission']);
                }
            }
        }else{
            $role                   = $this->model->with(['Permission'])->find($id);
            $role->name             = $input['name'];
            $role->label            = $input['label'];

            if($role->save())
            {
                $permission_role            = [];

                foreach($role->permission as $permission){
                    $permission_role[]  = $permission->id;
                }

                $role->detachPermission($permission_role);

                if(isset($input['permission'])){
                    $role->attachPermission($input['permission']);
                }
            }
        }

        return $this->listener->passed($action, $id);
    }

    public function edit($id){

        $role               = $this->model->find($id);
        $data['name']       = $role->name;
        $data['label']      = (is_null(old('label'))?$role->label:old('label'));

        return $data;
    }

    public function destroy($id){

        return $this->model->find($id)->delete();
    }
}