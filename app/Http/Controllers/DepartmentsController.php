<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function index()
    {
        $departments = DB::table('departments')->select('id', 'name')->get();
        if(is_null($departments) || !$departments->count()){
            return response()->json('No Departments Found', 404);
        }

        return response()->json($departments, 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Add the Department', 400);
        }
        $department=new Department();
        $department->name=$request->name;
        if($department->save()) {
            return response()->json('Added Successfully', 200);
        }
    }

    public function update(Request $request, $department_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json('Can not Edit the Department', 400);
        }

        $department= Department::find($department_id);
        if(is_null($department)){
            return response()->json('Department not Found', 404);
        }
        $department->name = $request->name;
        if($department->save()) {
            return response()->json('Updated Successfully', 200);
        }
        return response()->json('Can not Edit the Department', 400);
    }


    public function destroy($department_id)
    {
        $department= Department::find($department_id);
        if(is_null($department)){
            return response()->json('Department not Found', 404);
        }
        $department->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
