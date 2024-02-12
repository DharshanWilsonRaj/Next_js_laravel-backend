<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'emp_id' => 'required',
            'phone' => 'required|numeric',
            "department" => 'required',
            "doj" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'success' => false], 200);
        }

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'emp_id' => $request->input('emp_id'),
            'phone' => $request->input('phone'),
            'department' => $request->input('department'),
            'doj' => $request->input('doj'),
            'role' => 2,
        ]);
        $user->save();
        return response()->json(['data' => "Register SuccessFully",  'success' => true], 200);
    }

    public function login(Request $request)
    {

        $input = $request->only(['email', 'password']);
        if (Auth::attempt($input)) {
            $user = Auth::user();
            $token = $user->createToken('accesstoken')->plainTextToken;
            return response()->json(['success' => true, 'user' => $user->name, 'token' => $token], 200);
        }
        return response()->json(['success' => false], 200);
    }
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response()->json(['success' => true, 'message' => 'Logged out successfully'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
    }

    public function userDetails()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json(['success' => true, 'data' => $user]);
        }
        return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
    }
}
