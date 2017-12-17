<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthUser
{

    private $token;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->token = $request->cookie('token');

        $user = DB::table('users')->where('token', $this->token)->get();
        if (count($user)) {
            Auth::loginUsingId($user[0]->id);
        }
        
        return $next($request);
    }
}
