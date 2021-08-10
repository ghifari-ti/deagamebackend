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
        $user = User::where('email', $request->email)->first();
        if($user == null)
        {
            return response()->json(['status' => 'error', 'description' => 'Email tidak ditemukan'], 400);
        }
        if(!Hash::check($request->password, $user->password))
        {
            return response()->json(['status' => 'error', 'description' => 'Passowrd salah'], 400);
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

    public function loginWeb(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            return redirect()->back();
        }

        if(!Hash::check($request->passsword, $user->password))
        {
            return redirect()->back();
        }

    }
}
