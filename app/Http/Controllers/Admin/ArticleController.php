<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\User;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function add()
    {
        $viewData['pageTitle'] = "Add Article";
        return view(roleFolder().'.article.add',$viewData);
    } 


}
