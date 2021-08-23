<?php
namespace App\Http\Middleware;

use Closure;
use DB;
use Session;
use Redirect;
use App\User;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Route;

class UserToken extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['message' => "You are not authorized to access this url, Please login again." ], 402);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => "You are not authorized to access this url, Please login again." ], 402);
            }else{
                return response()->json(['message' => "You are not authorized to access this url, Please login again." ], 402);
            }
        }
        return $next($request);
    }
}
