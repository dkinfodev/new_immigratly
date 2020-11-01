<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;

class User
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
        if(Auth::check()){
           
            if(Auth::user()->role == 'user'){
                if(Auth::user()->is_active == 0){
                    Auth::logout();
                    return Redirect::to('/login')->with("error_message","Your account is not inactive. Please contact the support team");
                }
                if(Auth::user()->is_verified == 0){
                    Auth::logout();
                    return Redirect::to('/login')->with("error_message","Your account is not verified yet. Check your email or contact the support team");
                }
                return $next($request);
            }
            else{
                return Redirect::to('/home');
            }
        }else{
            return Redirect::to('/login');
        }
    }
}
