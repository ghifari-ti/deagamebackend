<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$auth = $request->header('Authorization'))
        {
            return response()->json(['status' => 'error', 'description' => 'unauthorized'], 401);
        }
        $check = count(Token::where('token', $auth)->get());
        if(!$check){
            return response()->json(['status' => 'error', 'description' => 'unauthorized'], 401);
        }
        return $next($request);
    }
}
