<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{


    public function index()
    {
        $leaves = Leave::orderByDesc('id')->get();
        return response()->json(['success' => true, 'data' => $leaves]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'department' => 'required',
            'fromDate' => 'required',
            'toDate' => 'required',
            'subject' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'success' => false], 400);
        }

        $leave = new Leave([
            'name' => $request->input('name'),
            'department' => $request->input('department'),
            'fromDate' => $request->input('fromDate'),
            'toDate' => $request->input('toDate'),
            'subject' => $request->input('subject'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
        ]);

        $leave->save();
        return  response()->json(['message' => "Employee leave added sucessfully",  'success' => true], 200);
    }


    public function edit($id)
    {
        $leave = Leave::where('id', $id)->firstOrFail();
        if ($leave) {
            return response()->json(['success' => true, 'data' => $leave], 200);
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);
        if ($leave) {
            $leave->update([
                'name' => $request->name,
                'department' => $request->department,
                'fromDate' => $request->fromDate,
                'toDate' => $request->toDate,
                'status' => $request->status,
            ]);
            return response()->json(['success' => true, 'message' => "successfully updated"], 200);
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }

    public function delete($id)
    {
        $leave = Leave::where('id', $id)->firstOrFail();
        if ($leave) {
            $leave->delete();
        } else {
            return response()->json(['success' => false, 'message' => "something went worng"], 400);
        }
    }
    public function employeeLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'department' => 'required',
            'fromDate' => 'required',
            'toDate' => 'required',
            'subject' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'success' => false], 400);
        }
        $leave = new Leave([
            'name' => $request->input('name'),
            'department' => $request->input('department'),
            'fromDate' => $request->input('fromDate'),
            'toDate' => $request->input('toDate'),
            'subject' => $request->input('subject'),
            'type' => $request->input('type'),
            'status' => 2,
        ]);

        $leave->save();
        return  response()->json(['message' => "Employee leave added sucessfully",  'success' => true], 200);
    }
}
