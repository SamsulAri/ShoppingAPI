<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
                $user = JWTAuth::toUser($request->input('token'));
            }
            catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
                {
                    return response()->json(['error' => 'Token is Invalid']);
                }
                else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
                {
                    return response()->json(['error' => 'Token is Expired']);
                }
                else
                {
                    return response()->json(['error' => 'Something is wrong']);
                }
            }
        return $next($request);
    }

}
