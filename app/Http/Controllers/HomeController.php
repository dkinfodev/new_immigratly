<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(\Auth::check()){
            return redirect(baseUrl('/'));
        }else{
            return redirect('/login');
        }
    }

    public function welcome_page(){
        if(\Session::get("professional_register")){
            $viewData['portal_url'] = \Session::get("portal_url");
            $viewData['pageTitle'] = "Welcome";
            $viewData['bodyClass'] = 'aboutus';
            \Session::forget("portal_url");
            \Session::forget("professional_register");
            return view('welcome',$viewData);
        }else{
            return redirect('/');
        }
    }
}
