<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;

class Executive
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
            if(Auth::user()->role == 'executive')
                return $next($request);
            else
                return Redirect::to('/home');
        }else{
            return Redirect::to('/login');
        }
    }
}
