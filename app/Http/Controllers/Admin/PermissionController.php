<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Operator;
use App\Model\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function show()
    {
        $data['roles']=Role::all()->toArray();
        return view('admin.permission.index',$data);
    }

    public function index(Request $request)
    {
        $start=$request->input('start', 0);
        $length=$request->input('length', 5);
        $draw=$request->input('draw', 1);

        $operators=Operator::select('operators.id','operators.name','operators.email','operators.password','operators.created_at','roles.name as role_name')
            ->join('roles','roles.id','=','operators.role_id')->skip($start)->take($length)->orderBy('id','desc');

        echo json_encode(array(
            "draw"            => intval( $draw ),
            "recordsTotal"    => intval(Operator::count()),
            "recordsFiltered" => intval(Operator::count()),
            "data"            => $operators->get()->toArray()
        ));
    }

    public function detail($id)
    {
        $operator=Operator::find($id);
        $ret['meta']['code']=1;
        $ret['meta']['data']=$operator->toArray();
        echo json_encode($ret);
    }

    public function store(Request $requests)
    {
        $params=$requests->all();
        $params['password']=bcrypt($params['password']);
        $operator=Operator::where('email',$params['email'])->first();

        if(count($operator)>0){
            $ret['meta']['code']=0;
            $ret['meta']['error']=$params['email'].'已经存在';
        }else{
            Operator::create($params);
            $ret['meta']['code']=1;
        }
        echo json_encode($ret);
    }

    public function update(Request $requests,$id)
    {
        $params=$requests->all();
        $operator=Operator::find($id);
        if($operator==null){
            $ret['meta']['code']=0;
            $ret['meta']['error']='目标不存在';
        }else{
            $operator->name=$params['name'];
            $operator->email=$params['email'];
            if($params['password']!=''){
                $operator->password=bcrypt($params['password']);
            }

            $operator->role_id=$params['role_id'];
            $operator->save();
            $ret['meta']['code']=1;
        }
        echo json_encode($ret);
    }

    public function delete($id)
    {
        Operator::find($id)->delete();
        $ret['meta']['code']=1;
        echo json_encode($ret);
    }
}
