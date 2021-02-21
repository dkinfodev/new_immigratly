<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;

use App\Models\DomainDetails;

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
                $setting = DomainDetails::first();
                if($setting->profile_status == 2){
                    return $next($request);
                }else{
                    if($request->ajax()){
                        $response['status'] = "error";
                        $response['message'] = "Not allowed to access this before profile approved";
                        return response()->json($response);
                    }else{
                        return Redirect::to(baseUrl('/complete-profile'));
                    }
                    
                }
            }else{
                return Redirect::to('/home');
            }
        }else{
            return Redirect::to('/login');
        }
    }
}
