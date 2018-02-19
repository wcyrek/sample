<?php

namespace App\Http\Middleware;

use Closure, App\User, Auth;

class AuthenticateJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //check if not already authenticated
        if (Auth::check()) {
            //do something
        }
        //check if we have a token; for laziness sake we will use parameters for token instead of header
        $token = $request->get('token', false);
        if (!$token) {
            //do something
        }
        $jwt = app()->make('JWTHelper');

        $user = $jwt->extractUser($token);
        Auth::loginUsingId($user['id']);

        return $next($request);
    }
}
