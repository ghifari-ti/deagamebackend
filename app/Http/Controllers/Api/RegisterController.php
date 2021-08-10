<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',

        ], [
            'username.required' => 'username wajib diisi',
            'username.unique' => 'username telah digunakan',
            'email.required' => 'email wajib diisi',
            'email.email' => 'Email harus dalam format email',
            'email.unique' => 'email telah digunakan',
            'password.required' => 'password wajib diisi',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 'OK', 'description' => 'user created'], 200);
    }
}
