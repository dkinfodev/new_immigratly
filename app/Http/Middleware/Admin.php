<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;

class Admin
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
            if(Auth::user()->role == 'admin'){
                if(Auth::user()->profile_status == 1){
                    return $next($request);
                }else{
                    return Redirect::to('/profile-create');
                }
            }
            else
                return Redirect::to('/home');
        }else{
            return Redirect::to('/login');
        }
    }
}
