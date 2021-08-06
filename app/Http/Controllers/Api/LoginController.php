<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if($user == null)
        {
            return response()->json(['status' => 'error', 'description' => 'username not found'], 401);
        }
        if(!Hash::check($request->password, $user->password))
        {
            return response()->json(['status' => 'error', 'description' => 'wrong password'], 401);
        }
        if($user->token()->first() == null)
        {
            $token = new Token;
            $token->user_id = $user->id;
            $token->token = Uuid::uuid4();
            $token->expired = '-';
        } else {
            $token = Token::where('user_id', $user->id)->first();
            $token->token = Uuid::uuid4();
            $token->expired = '-';
        }
            $token->save();
        return response()->json(['status' => 'OK', 'token' => $token->token], 200);
    }
}
