<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = User::where('role',2)->orderByDesc('id')->get();
        return response()->json(['success' => true, 'data' => $employee], 200);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'emp_id' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'department' => 'required',
            'doj' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'success' => false], 400);
        }
        $employee = new Employees([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'emp_id' => $request->input('emp_id'),
            'phone' => $request->input('phone'),
            'department' => $request->input('department'),
            'doj' => $request->input('doj'),
        ]);
        $employee->save();
        return  response()->json(['message' => "Employee Added sucessfully",  'success' => true], 200);
    }


    public function edit($id)
    {
        $employee = User::where('id', $id)->firstOrFail();
        if ($employee) {
            return response()->json(['success' => true, 'data' => $employee], 200);
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $employee = User::where('id', $id)->firstOrFail();
        if ($employee) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'emp_id' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'department' => 'required',
                'doj' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors(), 'success' => false], 400);
            }

            $employee->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'emp_id' => $request->input('emp_id'),
                'phone' => $request->input('phone'),
                'department' => $request->input('department'),
                'doj' => $request->input('doj'),
            ]);
            return response()->json(['success' => true, 'message' => "Employee Updated Successfully"], 200);
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }
    
    public function delete($id)
    {
        $employee = User::where('id', $id)->firstOrFail();
        if ($employee) {
            $employee->delete();
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }

}
