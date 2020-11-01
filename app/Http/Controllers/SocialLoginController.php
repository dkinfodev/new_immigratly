<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Models\User;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function Callback($provider){
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();

        if($users){
            if($users->role == 'user'){
                Auth::loginUsingId($users->id);
                return redirect(baseUrl('/')); 
            }else{
                return redirect('/login')->with("error_message","Your account is registered as ".$users->role.". Please try to login with your credentails or contact the support team"); 
            }
        }else{
            $name = explode(" ",$userSocial->getName());
            $last_name = '';
            $first_name = '';
            if(isset($name[0])){
                $first_name = $name[0];
            }
            if(isset($name[1])){
                $last_name = $name[1];
            }

            $user = User::create([
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $userSocial->getEmail(),
                'password'      => bcrypt('demo@123'),
                'profile_image' => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
                'is_active'     => 1,
                'is_verified'   => 1,
                'role'          =>'user'
            ]);   
            Auth::login($user);
             
            return redirect('/home');
        }
    }
}