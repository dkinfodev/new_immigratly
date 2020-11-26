<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\Languages;

class ProfessionalCasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function cases()
    {
       	$viewData['pageTitle'] = "Professionals";
        return view(roleFolder().'.cases.lists',$viewData);
    }
    
    public function getAjaxList(){
        
    }
}
