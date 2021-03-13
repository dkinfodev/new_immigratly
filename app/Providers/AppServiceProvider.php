<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\VisaServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $visa_services = VisaServices::with('SubServices')
                                    ->where("parent_id",0)
                                    ->select("id","name","slug","unique_id")
                                    ->get();
        
        view()->share('visa_services', $visa_services);
    }
}
