<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('professional');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }
}
