<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use DB;
use Razorpay\Api\Api;
use Image;
use View;
use App\Models\Articles;
use App\Models\News;
use App\Models\Professionals;

class FrontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(\Session::get('login_to') == 'professional_panel'){
            redirect("/login");
        }
    }

    public function index(){

     $articles = Articles::get();
     $news = News::get();
     $professionals = Professionals::get();

     $viewData['professionals'] = $professionals;
     $viewData['articles'] = $articles;   
     $viewData['news'] = $news;   
     $viewData['pageTitle'] = "Home Page";   
     return view('frontend.index',$viewData);
     
    }	

    
}
