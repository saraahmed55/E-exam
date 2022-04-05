<?php

namespace App\Http\Controllers;

use App\Models\AdminRole;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{

    public function index(){
        $user_roles = DB::table('roles')->select('id', 'name')->get();
        if(is_null($user_roles) || !$user_roles->count()){
            return response()->json('No Professors Found', 404);
        }

        return response()->json($user_roles, 200);
    }

    public function show($role_id){

        $professor = DB::table('professors')
        ->select('id', 'prof_code', 'first_name', 'last_name','email')
        ->where('roles_id', $role_id)->get();

        if(is_null($professor)|| !$professor->count()){
            return response()->json(' no professors Found', 404);
        }
        return response()->json($professor, 200);
    }

    public function update(Request $request,$professor_id){
        $validator = Validator::make($request->all(), [
            'roles_id'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the professor role', 400);
        }
        $professor= Professor::find($professor_id);
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        $professor->roles_id = $request->roles_id;
        if($professor->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Professor', 400);
    }
    public function getProfessorRole($professor_id){

        $professor =  DB::table('professors')
        ->select('id', 'roles_id')
        ->where('id', $professor_id)->first();
        if(is_null($professor)){
            return response()->json('Professor not Found', 404);
        }
        return response()->json();
    }
    public function getProfessorsOfRole($role_id){

        if( is_null($role_id)){
            return response()->json('No Roles Found', 404);
        }

        $professors = DB::table('professors')->join('roles', 'roles.id', '=', 'professors.roles_id')
        ->select('professors.id','professors.first_name','professors.last_name','professors.prof_code','professors.email')->where('roles_id',$role_id)->get();

        if(is_null($professors) || !$professors->count()){
            return response()->json('No Professors Found', 404);
        }

        return response()->json($professors, 200);
    }

}
