<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $subdomain = explode('.', $request->getHost())[0];

        \Session::forget("login_to");
        \Session::forget("subdomain");
        if($subdomain != 'localhost'){
            if($subdomain != 'immigratly'){
                \Session::put("login_to",'professional_panel');    
                // if($subdomain == 'users'){      
                //     \Session::put("login_to",'user_panel');
                // }else{
                    
                // }
                \Session::put("subdomain",$subdomain);
                \Config::set('database.connections.mysql.database', 'immigrat_immigratly_'.$subdomain);
            }else{
                \Session::put("login_to",'admin_panel');
            }
        }else{
           
            $login_to = 'professional_panel'; // admin_panel/professional_panel
            \Session::put("login_to",$login_to);
            
            if($login_to == 'professional_panel'){
                \Session::forget("subdomain");
                \Session::put("subdomain",'immi');
              
                \Config::set('database.connections.mysql.database', 'immigrat_immigratly_immi');
                \DB::purge('mysql');
                // \Config::set('database.connections.mysql.database', 'immigrat_immigratly_fastzone');
            }
        }
        
    }
}
